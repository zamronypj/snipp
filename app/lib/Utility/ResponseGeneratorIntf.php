<?php
namespace Snippet\Utility;

interface ResponseGeneratorIntf
{

    /**
     * Utitity for creating response object
     * @param $responseCode HTTP error code
     * @param $responseString string contains message
     * @param $data actual data to be sent to client
     * @param $newToken csrf token (if applicable)
     * @return Phalcon\Http\Response
     */
    public function createResponse($responseCode, $responseString, $data, $newToken);
}
