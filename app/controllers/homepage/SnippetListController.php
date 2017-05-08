<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;

class SnippetListController extends BaseHomepageController {
    private function getFeaturedSnippets() {
        return Snippets::find();
    }

    public function indexAction() {
        $this->view->featuredSnippets = $this->getFeaturedSnippets();
    }
}

