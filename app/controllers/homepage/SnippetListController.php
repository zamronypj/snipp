<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;
use \StdClass;

class SnippetListController extends BaseHomepageController
{
    private function getFeaturedSnippets($offset, $take) {
        return Snippets::find([
            'limit' => $take,
            'offset' => $offset
        ]);
    }

    public function indexAction() {
        $take = $this->config->snippetsPerPage;
        $page = $this->request->getQuery('page', 'int', 1);
        $page = $page >= 1 ? $page : 1;
        $paginator = new StdClass();
        $paginator->before = $page - 1;
        $paginator->next = $page + 1;
        $this->view->featuredSnippets = $this->getFeaturedSnippets(($page-1) * $take, $take);
        $this->view->page = $paginator;
    }

    public function listCurrentUserSnippetsAction() {
        if ($this->session->has('user')) {
            $take = $this->config->snippetsPerPage;
            $offset = $this->request->getQuery('skip', 'int', 0);
            $currentUser = $this->session->get('user');
            $this->view->featuredSnippets = $currentUser->snippets->find([
                'limit' => $take,
                'offset' => $offset
            ]);
        } else {
            $this->notFound();
        }
    }
}

