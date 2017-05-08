<?php
namespace Snippet\Utility;

interface RandomStringGeneratorIntf {

    /**
     * Utitlity for creating random string of certain length
     * @param $length integer length of random string
     * @return string
     */
    public function createRandomString($length);
}
