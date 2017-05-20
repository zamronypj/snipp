<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Task\Users\UserAuthenticationTask;

class SignInController extends BaseHomepageController
{

    public function indexAction() {
        $this->view->token = $this->tokenGenerator->generateCsrfToken();
    }

    private function handleUserLoginAction() {
        $authTask = new UserAuthenticationTask($this->request, $this->security, $this->logger);
        $authResult = $authTask->authUser();
        if ($authResult->status) {
            $this->session->set('user', $authResult->data);
            $this->response->redirect('/');
        } else {
            $this->session->remove('user');
            $this->response->redirect('signin/failed');
        }
    }

    public function authAction() {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                return $this->handleUserLoginAction();
            } else {
                $this->logger->error('Sign in no CSRF token');
                $this->notFound();
            }
        } else {
            //we only accept POST request,
            //something is wrong so just return 404 and log the issue
            $this->notFound();
        }

    }

    public function failedAction() {

    }
}

