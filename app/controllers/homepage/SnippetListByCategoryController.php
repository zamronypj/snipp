<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Snippets\SnippetListByCategoryTask;
use StdClass;

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
        $page = $this->request->getQuery('page', 'int', 1);
        $page = $page >= 1 ? $page : 1;
        $paginator = new StdClass();
        $paginator->before = $page - 1;
        $paginator->next = $page + 1;
        $offset = ($page-1) * $take;
        $snippetListTask = new SnippetListByCategoryTask($this->request,
                                $this->security,
                                $this->logger);
        $this->view->categoryName = $categoryName;
        $this->view->snippets = $snippetListTask->listPublicSnippetInCategory($categoryName, $offset, $take);
        $this->view->page = $paginator;
    }

}
