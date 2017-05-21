<?php
namespace Snippet\Utility;

/**
 * Utility for date
 */
interface DateServiceInterface
{

    /**
     * formatting date as a friendly human format
     * @param $datetimeValue input date to be formatted
     * @param $datetimeFormat format of input date
     * @return string human friendly formatted date
     */
    public function humanFriendly($datetimeValue, $datetimeFormat);
}
