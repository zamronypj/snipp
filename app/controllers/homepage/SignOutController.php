<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;

class SignOutController extends BaseHomepageController
{

    public function indexAction() {
        $this->session->remove('user');
        $this->response->redirect('/');
    }
}

