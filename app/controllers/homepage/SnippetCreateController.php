<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Filter;
use Snippet\Models\Snippets;
use \StdClass;

class SnippetCreateController extends BaseHomepageController
{

    private function generateResponseData($snippetObj, $appUrl) {
        $snippetData =  new StdClass();
        $snippetData->snippetId = $appUrl. 's/'. $snippetObj->id;
        return $snippetData;
    }

    private function outputJson($snippetObj, $appUrl) {
        $snippetData =  $this->generateResponseData($snippetObj, $appUrl);
        $csrfToken = $this->tokenGenerator->generateCsrfToken();
        return $this->responseGenerator->createResponse(200, 'OK', $snippetData, $csrfToken);
    }

    private function outputErrorJson($errorCode, $errorMsg) {
        return $this->responseGenerator->createResponse(500, 'Something is wrong',
            array(
                'error_code' => $errorCode,
                'error_msg' => $errorMsg
            ));
    }

    private function addSanitizedSnippet($actualSanitizedSnippet) {
        $this->view->disable();
        $len = $this->config->maxSnippetIdLength;
        $appUrl = $this->config->appUrl;
        $snippet = new Snippets();
        $snippet->id = $this->randomStr->createRandomString($len);
        $snippet->title = 'test';
        $snippet->content = $actualSanitizedSnippet;
        $snippet->save();
        return $this->outputJson($snippet, $appUrl);
    }

    private function handlePostAddSnippetAction() {
        $actualSnippet = $this->request->getPost('snippet');
        return $this->addSanitizedSnippet($actualSnippet);
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