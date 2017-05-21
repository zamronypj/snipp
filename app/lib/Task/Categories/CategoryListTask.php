<?php
namespace Snippet\Task\Categories;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;
use Snippet\Utility\ResponseGeneratorInterface;
use Snippet\Models\Categories;
use \StdClass;

/**
 * Class that encapsulate category list task
 */
class CategoryListTask extends BaseCategoryTask
{
    private $responseGenerator;

    public function __construct(RequestInterface $request, Security $security, LoggerInterface $logger,
                                ResponseGeneratorInterface $respGenerator)
    {
        $this->request = $request;
        $this->security = $security;
        $this->logger = $logger;
        $this->responseGenerator = $respGenerator;
    }

    private function buildSearchParamsByKeywords($keywords, $params)
    {
        $arrKeywords = explode(',', $keywords);
        $conditionParams = [];
        $bindParams = [];
        $paramNumber = 1;
        foreach($arrKeywords as $keyword) {
            $trimmedKeyword = trim($keyword);
            $conditionParams[] = "name LIKE ?$paramNumber";
            $bindParams[$paramNumber] = $trimmedKeyword.'%';
        }
        $params['conditions'] = join(' and ', $conditionParams);
        $params['bind'] = $bindParams;
        return $params;
    }

    private function buildSearchParameters($keywords, $offset, $take)
    {
        $params = [];

        if (strlen($keywords)) {
            $params = $this->buildSearchParamsByKeywords($keywords, $params);
        }

        if (isset($offset)){
            $params['offset'] = $offset;
        }

        if (isset($take)){
            $params['limit'] = $take;
        }

        return $params;
    }

    private function generateResponseData($categoriesObj)
    {
        $categories = [];
        foreach($categoriesObj as $category) {
            $categoryData = new StdClass();
            $categoryData->id = $category->id;
            $categoryData->name = $category->name;
            $categories[] = $categoryData;
        }
        return $categories;
    }

    private function outputJson($categoriesObj)
    {
        $categories =  $this->generateResponseData($categoriesObj);
        return $this->responseGenerator->createResponse(200, 'OK', $categories, null);
    }

    public function searchCategories($keywords, $offset = null, $take = null)
    {
        return Categories::find($this->buildSearchParameters($keywords, $offset, $take));
    }

    public function listCategories()
    {
        $keywords = $this->request->getQuery('keywords', 'string', '');
        $categories = $this->searchCategories($keywords);
        return $this->outputJson($categories);
    }
}