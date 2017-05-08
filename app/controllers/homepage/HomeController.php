<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;

class HomeController extends BaseHomepageController {
    private function getFeaturedSnippets() {
        return Snippets::find();
    }

    public function indexAction() {
        $this->view->token = $this->tokenGenerator->generateCsrfToken();
        $this->view->featuredSnippets = $this->getFeaturedSnippets();
    }
}

