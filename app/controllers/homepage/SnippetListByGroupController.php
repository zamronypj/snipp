<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListTask;
use StdClass;
use Snippet\Utility\PaginationFactory;


class SnippetListByGroupController extends BaseHomepageController
{
    private function getSnippets($offset, $take)
    {
        $user = $this->session->has('user') ? $this->session->get('user') : null;
        $snippetListTask = new SnippetListTask($this->request,
                                               $this->security,
                                               $this->logger);
        return (object)[
            'snippets' => $snippetListTask->listAvailableSnippet($user, $offset, $take),
            'totalSnippets' => $snippetListTask->countAvailableSnippet($user)
        ];
    }

    /**
     * List all snippet in a group that user has access to it
     */
    private function listAvailableSnippetInGroup($groupName, $user)
    {
        $take = $this->config->snippetsPerPage;
        $page = $this->request->getQuery('page', 'int', 0);
        $page = $page < 0 ? 0 : $page;
        $offset = $page * $take;
        $result =$this->getFeaturedSnippets($offset, $take);
        $this->view->snippets = $result->snippets;
        $totalSnippets = $result->totalSnippets;
        $url = $this->url;
        $currentUrlCallback = function($page) use ($url) {
            return $url->get([ 'for' => 'snippet-list' ]);
        };
        $paginator = (new PaginationFactory())->create(floor($offset/$take),
                                                    $totalSnippets,
                                                    $take,
                                                    $this->view,
                                                    $currentUrlCallback);
        $this->view->page = $paginator;
        $this->view->totalSnippets = $totalSnippets;
    }

    private function forwardTo($routeName)
    {
        //TODO:implements this as middleware
        $this->dispatcher->forward([
            'namespace' => 'Snippet\Controllers\Homepage',
            'controller' => $routeName,
            'action' => 'index'
        ]);
    }

    /**
     * List all snippet in a group that user has access to it
     */
    public function indexAction($groupName)
    {
        $sanitizedGroupName = $this->filter->sanitize($groupName, 'string');
        if ($this->session->has('user')) {
            $user = $this->session->has('user');
            if ($user->hasAccess($sanitizedGroupName)) {
                $this->listAvailableSnippetInGroup($sanitizedGroupName);
            } else {
                $this->forwardTo('not-allowed');
            }
        } else {
            if ($sanitizedGroupName === 'public') {
                $this->forwardTo('snippet-list');
            } else {
                $this->forwardTo('sign-in');
            }

        }
    }
}
