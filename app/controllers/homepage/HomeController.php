<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;

class HomeController extends BaseHomepageController {
    private function getFeaturedSnippets() {
        return Snippets::find([ 'limit' => 7 ]);
    }

    public function indexAction() {
        $this->view->token = $this->tokenGenerator->generateCsrfToken();
        $this->view->featuredSnippets = $this->getFeaturedSnippets();
        $this->view->customJs = $this->view->getPartial('home/home.js', ['theme' => $this->config->theme]);
    }
}

