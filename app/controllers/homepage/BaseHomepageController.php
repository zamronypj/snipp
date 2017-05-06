<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\BaseController;

class BaseHomepageController extends BaseController {
    public function initialize() {
        $this->view->setViewsDir(VIEWS_PATH. $this->config->theme. '/homepage/');
        $this->view->theme = $this->config->theme;
        $this->view->appName = $this->config->appName;
    }
}

