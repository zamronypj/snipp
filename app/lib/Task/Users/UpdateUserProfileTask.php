<?php
namespace Snippet\Task\Users;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;
use Snippet\Models\Users;
use Snippet\Models\UserDetails;
use \StdClass;


/**
 * Class that encapsulate update user profile process
 */
class UpdateUserProfileTask extends BaseUserTask
{
    private function reportStatus($code, $status, $data)
    {
        $result = new StdClass();
        $result->code = $code;
        $result->status = $status;
        $result->data = $data;
        return $result;
    }

    private function validateAndSanitizeInput(RequestInterface $request)
    {
        $sanitizedData = new StdClass();
        $sanitizedData->firstname = $request->getPost('firstname');
        $sanitizedData->lastname = $request->getPost('lastname');
        return $sanitizedData;
    }

    private function updateUserProfileToDb($userData, $currentUser)
    {
        $userDetails = new UserDetails();
        $userDetails->user_id = $currentUser->id;
        $userDetails->firstname = $userData->firstname;
        $userDetails->lastname = $userData->lastname;
        $userDetails->country = 'id';
        $userDetails->save();
        return $this->reportStatus(0, 'OK', 'ok');
    }

    public function updateUserProfile($currentUser)
    {
        $sanitizedData = $this->validateAndSanitizeInput($this->request);
        return $this->updateUserProfileToDb($sanitizedData, $currentUser);
    }
}
