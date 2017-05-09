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
        $snippetData->snippetId = $snippetObj->id;
        $snippetData->snippetUrl = $appUrl. 's/'. $snippetObj->id;
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

    private function addSanitizedSnippet($actualSanitizedSnippet, $snippetTitle) {
        $this->view->disable();
        $len = $this->config->maxSnippetIdLength;
        $appUrl = $this->config->appUrl;
        $snippet = new Snippets();
        $snippet->id = $this->randomStr->createRandomString($len);
        $snippet->title = strlen($snippetTitle) ? $snippetTitle : 'Untitled';
        $snippet->content = $actualSanitizedSnippet;
        $snippet->save();
        return $this->outputJson($snippet, $appUrl);
    }

    private function handlePostAddSnippetAction() {
        $filter = new Filter();
        $filter->add('specialchar', function($rawInput){
             return filter_var($rawInput, FILTER_SANITIZE_SPECIAL_CHARS);
        });
        $actualSnippet = $filter->sanitize($this->request->getPost('snippet'), 'specialchar');
        $snippetTitle = $filter->sanitize($this->request->getPost('snippetTitle'), 'string');
        return $this->addSanitizedSnippet($actualSnippet, $snippetTitle);
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