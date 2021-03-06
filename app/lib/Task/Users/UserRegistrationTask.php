<?php
namespace Snippet\Task\Users;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;
use Snippet\Models\Users;
use Snippet\Models\UserDetails;
use Snippet\Models\UserGroups;
use Snippet\Models\Groups;
use Snippet\Exception\User\RegistrationValidationException;
use \StdClass;

/**
 * Class that encapsulate user registration process
 */
class UserRegistrationTask extends BaseUserTask
{
    private function validateInput(RequestInterface $request)
    {
        $validationStatus = new StdClass();
        $validationStatus->status = true;
        //TODO: validate input
        return $validationStatus;
    }

    private function sanitizeInput(RequestInterface $request)
    {
        $sanitizedData = new StdClass();
        $sanitizedData->username = $request->getPost('username');
        $sanitizedData->password = $request->getPost('password');
        $sanitizedData->email = $request->getPost('email');
        $sanitizedData->firstname = $request->getPost('firstname');
        $sanitizedData->lastname = $request->getPost('lastname');
        return $sanitizedData;
    }

    private function validateAndSanitizeInput(RequestInterface $request)
    {
        $result = $this->validateInput($request);
        if ($result->status) {
            $result->sanitizedData = $this->sanitizeInput($request);
        }

        return $result;
    }

    private function saveUserData(StdClass $sanitizedData, Security $security, LoggerInterface $logger)
    {
        $logger->log('Registering user  -'.
                            ' username:' . $sanitizedData->username .
                            ' email:'.$sanitizedData->email);

        $newUser = new Users();
        $newUser->username = $sanitizedData->username;
        $newUser->userpswd = $security->hash($sanitizedData->password);
        $newUser->email = $sanitizedData->email;
        $newUser->save();

        $userDetail = new UserDetails();
        $userDetail->firstname = $sanitizedData->firstname;
        $userDetail->lastname = $sanitizedData->lastname;
        $userDetail->user_id = $newUser->id;
        $userDetail->country = 'id';
        $userDetail->save();

        //all user by default join public group
        //so when they login they still can view public snippet
        $publicGroup = Groups::findFirstByName('public');
        $userGroup = new UserGroups();
        $userGroup->user_id = $newUser->id;
        $userGroup->group_id = $publicGroup->id;
        $userGroup->save();
    }

    public function registerUser()
    {

        $validatedAndSanitizedData = $this->validateAndSanitizeInput($this->request);
        if ($validatedAndSanitizedData->status) {
            $this->saveUserData($validatedAndSanitizedData->sanitizedData, $this->security, $this->logger);
        } else {
            throw new RegisterValidationException('Wrong data');
        }

    }
}
