<?php
namespace Snippet\Controllers\Homepage;

use Phalcon\Filter;
use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Users\UpdateUserProfileTask;

class UpdateUserProfileController extends BaseHomepageController
{
    /**
     * update user profile of currently logged-in user
     */
    public function updateAction()
    {
        if ($this->session->has('user')) {

            $currentUser = $this->session->get('user');
            $task = new UpdateUserProfileTask($this->request, $this->security, $this->logger);
            $task->updateUserProfile($currentUser);

            $this->dispatcher->forward([
                'namespace' => 'Snippet\Controllers\Homepage',
                'controller' => 'user-profile',
                'action' => 'index'
            ]);
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
