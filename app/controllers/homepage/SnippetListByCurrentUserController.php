<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListTask;
use StdClass;
use Snippet\Utility\PaginationFactory;

class SnippetListByCurrentUserController extends BaseHomepageController
{
    /**
     * List all snippet created by currently logged-in user
     */
    public function listAction()
    {
        if ($this->session->has('user')) {
            $currentUser = $this->session->get('user');
            $take = $this->config->snippetsPerPage;
            $page = $this->request->getQuery('page', 'int', 0);
            $page = $page < 0 ? 0 : $page;
            $offset = $page * $take;
            $this->view->snippets = $currentUser->getSnippets([
                'limit' => $take,
                'offset' => $offset
            ]);
            $totalSnippets = $currentUser->snippets->count();
            $url = $this->url;
            $currentUrlCallback = function($page) use ($url) {
                return $url->get([
                    'for' => 'snippet-list-by-current-user'
                ]);
            };
            $paginator = (new PaginationFactory())->create(floor($offset/$take),
                                                        $totalSnippets,
                                                        $take,
                                                        $this->view,
                                                        $currentUrlCallback);
            $this->view->page = $paginator;
            $this->view->totalSnippets = $totalSnippets;
        } else {
            //TODO:implements this as middleware
            $this->dispatcher->forward([
                'namespace' => 'Snippet\Controllers\Homepage',
                'controller' => 'sign-in',
                'action' => 'index'
            ]);
        }
    }

}
