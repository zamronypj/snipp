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
        $offset = $this->request->getQuery('offset', 'int', 0);
        $offset = $offset < 0 ? 0 : $offset;

        $snippetListTask = new SnippetListByCategoryTask($this->request,
                                $this->security,
                                $this->logger);
        $this->view->categoryName = $categoryName;
        $this->view->snippets = $snippetListTask->listPublicSnippetInCategory($categoryName, $offset, $take);
        $totalSnippets = (int)(($snippetListTask->countPublicSnippetInCategory($categoryName))[0]->total);
        $paginator = (new PaginationFactory())->create('http://fux.com', $this->view, floor($offset/$take), $totalSnippets, $take);
        $this->view->page = $paginator;
    }

}
