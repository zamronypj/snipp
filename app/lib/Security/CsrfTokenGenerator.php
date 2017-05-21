<?php
namespace Snippet\Security;

use \StdClass;
use Phalcon\Security;

/**
 * class that encapsulate Crsf token generation functionality
 */
class CsrfTokenGenerator implements CsrfTokenGeneratorInterface
{
    /**
     * @var Phalcon\Security
     */
    private $security;

    public function __construct(Security $securityObj)
    {
        $this->security = $securityObj;
    }

    public function generateCsrfToken()
    {
        $token = new StdClass();
        $token->name = $this->security->getTokenKey();
        $token->value = $this->security->getToken();
        return $token;
    }
}
