<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Http\Response;
use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;

class SnippetDetailController extends BaseHomepageController {
    public function indexAction($snippetId) {
        $filter = new Filter();
        $sanitizedSnippetId = $filter->sanitize($snippetId, 'alphanum');
        $foundSnippet= Snippets::findFirstByid($sanitizedSnippetId);

        if ($foundSnippet) {
            $this->view->snippet = $foundSnippet;
            $this->view->customJs = $this->view->getPartial('snippet-detail/highlight.js', ['theme' => $this->config->theme ]);
        } else {
            $this->notFound();
        }
    }
}

