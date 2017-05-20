<?php
namespace Snippet\Task;

use Phalcon\Security;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Http\RequestInterface;

/**
 * Class that encapsulate application task
 */
class BaseTask
{
    protected $security;
    protected $request;
    protected $logger;

    public function __construct(RequestInterface $request, Security $security, LoggerInterface $logger)
    {
        $this->request = $request;
        $this->security = $security;
        $this->logger = $logger;
    }
}
