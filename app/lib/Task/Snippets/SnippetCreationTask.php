<?php
namespace Snippet\Task\Snippets;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;
use Phalcon\Filter;
use Snippet\Models\Snippets;
use Snippet\Models\Acls;
use Snippet\Models\Groups;
use Snippet\Models\SnippetCategories;
use StdClass;
use Snippet\Utility\ResponseGeneratorInterface;
use Snippet\Utility\RandomStringGeneratorIntf as RandomStringGeneratorInterface;
use Snippet\Security\CsrfTokenGeneratorInterface as TokenGeneratorInterface;
use Snippet\Task\Snippets\BaseSnippetTask;
use Snippet\Task\Categories\CategoryCreateTask;

/**
 * Class that encapsulate snippet creation task
 */
class SnippetCreationTask extends BaseSnippetTask
{
    private $responseGenerator;
    private $tokenGenerator;
    private $randomStr;
    private $currentUser;
    private $appUrl;
    private $snippetIdLen;

    public function __construct(RequestInterface $request, Security $security, LoggerInterface $logger,
                                ResponseGeneratorInterface $respGenerator, TokenGeneratorInterface $tokenGenerator,
                                RandomStringGeneratorInterface $randomStr, $currentUser, $appUrl, $snippetIdLen)
    {
        $this->request = $request;
        $this->security = $security;
        $this->logger = $logger;
        $this->responseGenerator = $respGenerator;
        $this->tokenGenerator = $tokenGenerator;
        $this->randomStr = $randomStr;
        $this->currentUser = $currentUser;
        $this->appUrl = $appUrl;
        $this->snippetIdLen = $snippetIdLen;
    }

    private function generateResponseData($snippetObj, $appUrl)
    {
        $snippetData =  new StdClass();
        $snippetData->snippetId = $snippetObj->id;
        $snippetData->snippetUrl = $appUrl. 's/'. $snippetObj->id;
        return $snippetData;
    }

    private function outputJson($snippetObj, $appUrl)
    {
        $snippetData =  $this->generateResponseData($snippetObj, $appUrl);
        $csrfToken = $this->tokenGenerator->generateCsrfToken();
        return $this->responseGenerator->createResponse(200, 'OK', $snippetData, $csrfToken);
    }

    private function addSanitizedSnippet($actualSanitizedSnippet, $snippetTitle,
                                         $appUrl, $snippetIdLen, $categories)
    {
        $snippet = new Snippets();
        $snippet->id = $this->randomStr->createRandomString($snippetIdLen);
        $snippet->title = strlen($snippetTitle) ? $snippetTitle : 'Untitled';
        $snippet->content = $actualSanitizedSnippet;
        if (isset($this->currentUser)) {
            $snippet->user_id = $this->currentUser->id;
        }
        $snippet->save();

        $publicGroup = Groups::findFirstByName('public');

        //add snippet to public group by default so anyone can view
        //TODO: add ability to assign snippet to certain group so only certain users in that group be able to view
        $acls = new Acls();
        $acls->snippet_id = $snippet->id;
        $acls->group_id = $publicGroup->id;
        $acls->save();

        if (count($categories)) {
            $this->createCategories($snippet->id, $categories);
        }

        return $this->outputJson($snippet, $appUrl);
    }

    private function createCategories($snippetId, $categories)
    {
        $categoriesCreateTask = new CategoryCreateTask($this->request, $this->security, $this->logger);
        $categoryIds = $categoriesCreateTask->createCategoriesIfNotExist($categories);
        foreach($categoryIds as $categoryId) {
            $snippetCat = new SnippetCategories();
            $snippetCat->snippet_id = $snippetId;
            $snippetCat->category_id = $categoryId;
            $snippetCat->save();
        }
    }

    public function createSnippet()
    {
        $filter = new Filter();
        $filter->add('specialchar', function ($rawInput) {
            return filter_var($rawInput, FILTER_SANITIZE_SPECIAL_CHARS);
        });
        $actualSnippet = $filter->sanitize($this->request->getPost('snippet'), 'specialchar');
        $snippetTitle = $filter->sanitize($this->request->getPost('snippetTitle'), 'string');
        //no need to sanitize here because
        //sanitizing will be done by CategoryCreateTask
        $categories = $this->request->getPost('categories');
        return $this->addSanitizedSnippet($actualSnippet, $snippetTitle,
                                          $this->appUrl, $this->snippetIdLen,
                                          $categories);
    }
}
