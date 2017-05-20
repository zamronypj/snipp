<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Snippets;
use Snippet\Models\Users;
use Snippet\Models\UserDetails;

class SnippetDetailController extends BaseHomepageController
{
    public function indexAction($snippetId) {
        $filter = new Filter();
        $sanitizedSnippetId = $filter->sanitize($snippetId, 'alphanum');
        $foundSnippet= Snippets::findFirstById($sanitizedSnippetId);

        if ($foundSnippet) {
            $this->view->snippet = $foundSnippet;
            if ($foundSnippet->user_id) {
                $snippetUser =  Users::findFirstById($foundSnippet->user_id);
                if ($snippetUser) {
                    $this->view->snippetUser = $snippetUser;
                    $snippetUserDetail = UserDetails::findFirstByUserId($snippetUser->id);
                    $this->view->snippetUserDetail = $snippetUserDetail;
                }
            }
            $this->view->customJs = $this->view->getPartial('snippet-detail/highlight.js', ['theme' => $this->config->theme ]);
        } else {
            $this->notFound();
        }
    }
}

