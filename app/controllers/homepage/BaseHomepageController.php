<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\BaseController;
use Snippet\Models\UserDetails;

class BaseHomepageController extends BaseController
{
    public function initialize() {
        $this->view->setViewsDir(VIEWS_PATH. $this->config->theme. '/homepage/');
        $this->view->theme = $this->config->theme;
        $this->view->appName = $this->config->appName;
        $this->view->appUrl = $this->config->appUrl;
        $this->view->user = $this->session->has('user') ? $this->session->get('user') : null;
        if ($this->session->has('user')) {
            $user = $this->session->get('user');
            $detail = UserDetails::findFirstByUserId($user->id);
            $this->view->userdetail = $detail;
        }
    }
}

