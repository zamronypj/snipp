<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListTask;
use \StdClass;

class SnippetListController extends BaseHomepageController
{
    private function getFeaturedSnippets($offset, $take)
    {
        $user = $this->session->has('user') ? $this->session->get('user') : null;
        $snippetListTask = new SnippetListTask($this->request, $this->security, $this->logger);
        return $snippetListTask->listAvailableSnippet($user, $offset, $take);
    }

    /**
     * List all snippet that user has access to it. For non-registered
     * user it means only snippet marked as public
     */
    public function indexAction()
    {
        $take = $this->config->snippetsPerPage;
        $page = $this->request->getQuery('page', 'int', 1);
        $page = $page >= 1 ? $page : 1;
        $paginator = new StdClass();
        $paginator->before = $page - 1;
        $paginator->next = $page + 1;
        $this->view->featuredSnippets = $this->getFeaturedSnippets(($page-1) * $take, $take);
        $this->view->page = $paginator;
    }

    /**
     * List all snippet created by currently logged-in user
     */
    public function listCurrentUserSnippetsAction()
    {
        if ($this->session->has('user')) {
            $take = $this->config->snippetsPerPage;
            $offset = $this->request->getQuery('skip', 'int', 0);
            $currentUser = $this->session->get('user');
            $this->view->featuredSnippets = $currentUser->getSnippets([
                'limit' => $take,
                'offset' => $offset
            ]);
        } else {
            //TODO:implements this as middleware
            $this->dispatcher->forward([
                'namespace' => 'Snippet\Controllers\Homepage',
                'controller' => 'sign-in',
                'action' => 'index'
            ]);
        }
    }

    /**
     * List all public snippet created by user
     */
    public function listPublicSnippetsByUserAction($username)
    {
        $filter = new Filter();
        $sanitizedUsername = $filter->sanitize($username, 'alphanum');
        $take = $this->config->snippetsPerPage;
        $offset = $this->request->getQuery('skip', 'int', 0);

        $snippetListTask = new SnippetListTask($this->request, $this->security, $this->logger);
        $this->view->featuredSnippets = $snippetListTask->listPublicSnippetByUsername($sanitizedUsername, $offset, $take);
        $this->view->username = $username;
    }
}
