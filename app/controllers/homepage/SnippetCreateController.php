<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetCreationTask;

class SnippetCreateController extends BaseHomepageController
{
    private function outputErrorJson($errorCode, $errorMsg) {
        return $this->responseGenerator->createResponse(500, 'Something is wrong',
            array(
                'error_code' => $errorCode,
                'error_msg' => $errorMsg
            ));
    }

    private function handlePostAddSnippetAction() {
        $this->view->disable();
        $currentUser = $this->session->has('user') ? $this->session->get('user') : null;
        $snippetCreationTask = new SnippetCreationTask($this->request, $this->security, $this->logger,
            $this->responseGenerator, $this->tokenGenerator, $this->randomStr, $currentUser,
            $this->config->appUrl, $this->config->maxSnippetIdLength);
        return $snippetCreationTask->createSnippet();
    }

    public function indexAction() {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                return $this->handlePostAddSnippetAction();
            } else {
                //no CSRF token
                return $this->outputErrorJson(3, 'Invalid token');
            }
        } else {
            //we only accept POST request
            return $this->outputErrorJson(2, 'Sorry only accept POST');
        }
    }
}