<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListByUserTask;
use StdClass;
use Snippet\Utility\PaginationFactory;

class SnippetListByUserController extends BaseHomepageController
{
    /**
     * List all public snippet created by user
     */
    public function listPublicAction($username)
    {
        $filter = new Filter();
        $sanitizedUsername = $filter->sanitize($username, 'alphanum');
        $take = $this->config->snippetsPerPage;
        $page = $this->request->getQuery('page', 'int', 0);
        $page = $page < 0 ? 0 : $page;
        $offset = $page * $take;

        $snippetListTask = new SnippetListByUserTask($this->request, $this->security,
                                               $this->logger);
        $this->view->snippets = $snippetListTask->listPublicSnippetByUsername($sanitizedUsername, $offset, $take);
        $this->view->username = $username;
        $totalSnippets = $snippetListTask->countPublicSnippetByUsername($sanitizedUsername);
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
