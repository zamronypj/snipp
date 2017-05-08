<?php
namespace Snippet\Security;

use \StdClass;

class CsrfTokenGenerator implements CsrfTokenGeneratorIntf
{
    private $security;

    public function __construct($securityObj) {
        $this->security = $securityObj;
    }

    public function generateCsrfToken() {
        $token = new StdClass();
        $token->name = $this->security->getTokenKey();
        $token->value = $this->security->getToken();
        return $token;
    }

}