<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Categories\CategoryListTask;

class CategoryListController extends BaseHomepageController
{

    public function listAction()
    {
        $this->view->disable();
        $categoryListTask = new CategoryListTask($this->request, $this->security,
                                                 $this->logger, $this->responseGenerator);
        return $categoryListTask->listCategories();
    }

}
