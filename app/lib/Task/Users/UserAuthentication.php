<?php
namespace Snippet\Task\Users;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;
use Snippet\Models\Users;
use Snippet\Models\UserDetails;
use \StdClass;

/**
 * Class that encapsulate user authentication process
 */
class UserAuthentication extends BaseUserTask {

    private function validateAndSanitizeInput(RequestInterface $request) {
        $sanitizedData = new StdClass();
        $sanitizedData->username = $request->getPost('username');
        $sanitizedData->password = $request->getPost('password');
        $sanitizedData->email = $request->getPost('email');
        $sanitizedData->firstname = $request->getPost('firstname');
        $sanitizedData->lastname = $request->getPost('lastname');
        return $sanitizedData;
    }

    private function authUserData(StdClass $sanitizedData, Security $security, LoggerInterface $logger) {
        if (isset($sanitizedData->username)) {
            Users::findFirstByUsername()

        } elseif (isset($sanitizedData->email)) {

        } else {
            return false;
        }
        $newUser = new Users();
        $newUser->username = $sanitizedData->username;
        $newUser->userpswd = $security->hash($sanitizedData->password);
        $newUser->email = $sanitizedData->email;
        $newUser->save();

        $userDetail = new UserDetails();
        $userDetail->firstname = $sanitizedData->firstname;
        $userDetail->lastname = $sanitizedData->lastname;
        $userDetail->lastname = $sanitizedData->lastname;
        $userDetail->user_id = $newUser->id;
        $userDetail->country = 'id';
        $userDetail->save();
    }

    public function authUser() {
        $sanitizedData = $this->validateAndSanitizeInput($this->request);
        return $this->authUserData($sanitizedData, $this->security, $this->logger);
    }

}