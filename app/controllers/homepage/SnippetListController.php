<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListTask;
use StdClass;
use Snippet\Utility\PaginationFactory;


class SnippetListController extends BaseHomepageController
{
    private function getFeaturedSnippets($offset, $take)
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
     * List all snippet that user has access to it. For non-registered
     * user it means only snippet marked as public
     */
    public function indexAction()
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

}
