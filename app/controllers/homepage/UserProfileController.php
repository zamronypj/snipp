<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use StdClass;

class UserProfileController extends BaseHomepageController
{
    /**
     * display profile of currently logged-in user
     */
    public function indexAction()
    {
        if ($this->session->has('user')) {
            $currentUser = $this->session->get('user');
            $this->view->currentUser = $currentUser;
        } else {
            //TODO:implements this as middleware
            $this->dispatcher->forward([
                'namespace' => 'Snippet\Controllers\Homepage',
                'controller' => 'sign-in',
                'action' => 'index'
            ]);
        }
    }

}
