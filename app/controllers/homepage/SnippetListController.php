<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;

class SnippetListController extends BaseHomepageController {
    private function getFeaturedSnippets($take) {
        return Snippets::find([
            'limit' => $take
        ]);
    }

    public function indexAction() {
        $take = $this->config->snippetsPerPage;
        $this->view->featuredSnippets = $this->getFeaturedSnippets($take);
    }

    public function listCurrentUserSnippetsAction() {
        if ($this->session->has('user')) {
            //$take = $this->config->snippetsPerPage;
            $currentUser = $this->session->get('user');
            $this->view->featuredSnippets = $currentUser->snippets;
        } else {
            $this->notFound();
        }
    }
}

