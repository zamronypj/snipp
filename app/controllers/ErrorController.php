<?php
namespace Snippet\Controllers;

use Snippet\Controllers\BaseController;

class ErrorController extends BaseController
{
    public function initialize() {
        $this->view->setViewsDir(VIEWS_PATH. $this->config->theme. '/homepage/');
        $this->view->theme = $this->config->theme;
        $this->view->appName = $this->config->appName;
    }

    public function error404Action() {
    }
}

