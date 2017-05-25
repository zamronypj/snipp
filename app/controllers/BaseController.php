<?php
namespace Snippet\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public function notFound()
    {
        $this->dispatcher->forward([
            'namespace'  => 'Snippet\Controllers',
            'controller' => 'error',
            'action'     => 'error404'
        ]);
    }
}
