<?php
namespace Snippet\Task\Users;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;
use Snippet\Models\Users;
use Snippet\Models\UserDetails;
use \StdClass;

define('AUTH_OK', 0);
define('AUTH_INVALID_INPUT_DATA', 1);
define('AUTH_USERNAME_NOT_REGISTERED', 2);
define('AUTH_INVALID_PASSW', 3);

/**
 * Class that encapsulate user authentication process
 */
class UserAuthenticationTask extends BaseUserTask {

    private function reportStatus($code, $status, $data) {
        $result = new StdClass();
        $result->code = $code;
        $result->status = $status;
        $result->data = $data;
        return $result;
    }

    private function validateAndSanitizeInput(RequestInterface $request) {
        $sanitizedData = new StdClass();
        $sanitizedData->username = $request->getPost('username');
        $sanitizedData->password = $request->getPost('password');
        return $sanitizedData;
    }

    private function authCheck($user, StdClass $sanitizedData) {
        if ($user) {
            if ($this->security->checkHash($sanitizedData->password, $user->userpswd)) {
                return $this->reportStatus(AUTH_OK, true, $user);
            } else {
                return $this->reportStatus(AUTH_INVALID_PASSW, false, null);
            }
        } else {
            return $this->reportStatus(AUTH_USERNAME_NOT_REGISTERED, false, null);
        }
    }

    private function authByUsername(StdClass $sanitizedData) {
        $user = Users::findFirstByUsername($sanitizedData->username);
        return $this->authCheck($user, $sanitizedData);
    }

    private function authByEmail(StdClass $sanitizedData) {
        $user = Users::findFirstByEmail($sanitizedData->email);
        return $this->authCheck($user, $sanitizedData);
    }

    private function authUserData(StdClass $sanitizedData, Security $security, LoggerInterface $logger) {
        if (isset($sanitizedData->username)) {
            return $this->authByUsername($sanitizedData);
        } elseif (isset($sanitizedData->email)) {
            return $this->authByEmail($sanitizedData);
        } else {
            return $this->reportStatus(AUTH_INVALID_INPUT_DATA, false, null);
        }
    }

    public function authUser() {
        $sanitizedData = $this->validateAndSanitizeInput($this->request);
        return $this->authUserData($sanitizedData, $this->security, $this->logger);
    }

}