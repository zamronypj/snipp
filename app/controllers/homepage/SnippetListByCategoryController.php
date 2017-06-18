<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListByCategoryTask;
use Snippet\Utility\PaginationFactory;

/**
 * List all snippet in specific category that user has access to it. For non-registered
 * user it means only snippet in specific category marked as public
 */
class SnippetListByCategoryController extends BaseHomepageController
{
    /**
     * List all snippet in specific that user has access to it. For non-registered
     * user it means only snippet marked as public
     * @param int $categoryName
     */
    public function indexAction($categoryName)
    {
        $take = $this->config->snippetsPerPage;
        $page = $this->request->getQuery('page', 'int', 0);
        $page = $page < 0 ? 0 : $page;
        $offset = $page * $take;

        $snippetListTask = new SnippetListByCategoryTask($this->request,
                                $this->security,
                                $this->logger);
        $this->view->categoryName = $categoryName;
        $this->view->snippets = $snippetListTask->listPublicSnippetInCategory($categoryName, $offset, $take);
        $totalSnippets = $snippetListTask->countPublicSnippetInCategory($categoryName);
        $url = $this->url;
        $currentUrlCallback = function($page) use ($categoryName, $url) {
            return $url->get([
                'for' => 'snippet-list-by-category',
                'categoryName' => $categoryName
            ]);
        };
        $paginator = (new PaginationFactory())->create(floor($offset/$take),
                                                       $totalSnippets,
                                                       $take,
                                                       $this->view,
                                                       $currentUrlCallback);
        $this->view->page = $paginator;
        $this->view->totalSnippets = $totalSnippets;
    }

}
