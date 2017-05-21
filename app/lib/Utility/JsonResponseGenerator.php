<?php
namespace Snippet\Utility;

use Phalcon\Http\Response;

class JsonResponseGenerator implements ResponseGeneratorInterface
{
    public function createResponse($responseCode, $responseString, $data, $newToken)
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setStatusCode($responseCode, $responseString);
        $response->setJsonContent(array(
            'response' => $responseCode,
            'data' => $data,
            'csrfToken' => $newToken
        ));
        return $response;
    }
}
