<?php
namespace Snippet\Validation;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class SignUpValidation extends Validation
{
    public function initialize()
    {
        $this->add('username', new PresenceOf([
            'message' => 'Username is required'
        ]));

        $this->add('email', new PresenceOf([
            'message' => 'E-mail is required'
        ]));

        $this->add('email', new Email([
           'message' => 'E-mail is not valid'
        ]));

        $this->add('password', new PresenceOf([
           'message' => 'Password is required'
        ]));
    }
}
