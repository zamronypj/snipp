<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Users;

class SignInController extends BaseHomepageController {
    public function indexAction() {
        $this->view->token = $this->tokenGenerator->generateCsrfToken();
    }

    private function validateAndSanitizeUserData() {

    }

    private function checkUserAuth($email, $password) {
        $user = Users::findFirst(
            [
                "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                "bind" => [
                    "email"    => $email,
                    "password" => sha1($password),
                ]
            ]
        );

    }

    private function handleUserLoginAction() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $this->validateAndSanitizeUserData();
        $user = $this->checkUserAuth();
        if ($user) {
            $this->session->set('user', $user);
        } else {
            //invalid user
            $this->session->remove('user');

        }
    }

    public function authAction() {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                return $this->handleUserLoginAction();
            } else {
                //something is wrong, no CSRF token
                $this->notFound();
            }
        } else {
            //we only accept POST request,
            //something is wrong so just return 404 and log the issue
            $this->notFound();
        }

    }
}

