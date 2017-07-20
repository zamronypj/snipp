<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetDetailTask;

class SnippetDetailController extends BaseHomepageController
{
    public function indexAction($snippetId)
    {
        $user = $this->session->has('user') ? $this->session->get('user') : null;
        $snippetDetailTask = new SnippetDetailTask($this->request, $this->security, $this->logger);
        $foundSnippet = $snippetDetailTask->viewDetail($snippetId, $user);

        if (isset($foundSnippet)) {
            $this->view->snippet = $foundSnippet;
            $this->view->customJs = $this->view->getPartial('snippet-detail/snippet.detail.js', ['theme' => $this->config->theme ]);
        } else {
            $this->notFound();
        }
    }
}
