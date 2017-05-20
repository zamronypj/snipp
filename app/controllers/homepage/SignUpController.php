<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Users\UserRegistrationTask;

class SignUpController extends BaseHomepageController
{
    public function indexAction()
    {
        $this->view->token = $this->tokenGenerator->generateCsrfToken();
    }

    private function handleRegisterUserAction()
    {
        $userRegistration = new UserRegistrationTask($this->request, $this->security, $this->logger);
        $userRegistration->registerUser();
    }

    public function registerAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                $this->handleRegisterUserAction();
            } else {
                $this->logger->critical('No CSRF token');
                $this->notFound();
            }
        } else {
            //we only accept POST request,
            //something is wrong so just return 404 and log the issue
            $this->notFound();
        }
    }
}
