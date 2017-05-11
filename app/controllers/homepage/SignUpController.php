<?php
namespace Snippet\Controllers\Homepage;

use Snippet\Controllers\Homepage\BaseHomepageController;
use Snippet\Models\Users;

class SignUpController extends BaseHomepageController {
    public function indexAction() {
        $this->view->token = $this->tokenGenerator->generateCsrfToken();
    }

    private function validateAndSanitizeInput() {

    }

    private function saveUserData() {

    }

    private function handleRegisterUserAction() {
        $this->validateAndSanitizeInput();
        $this->saveUserData();
    }

    public function registerAction() {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                return $this->handleRegisterUserAction();
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

