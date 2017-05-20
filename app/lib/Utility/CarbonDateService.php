<?php
namespace Snippet\Utility;

use Carbon\Carbon;

/**
 * Date service using Carbon
 */
class CarbonDateService implements DateServiceIntf
{

    /**
     * formatting date as a friendly human format
     * @param $datetimeValue input date to be formatted
     * @param $datetimeFormat format of input date
     * @return string human friendly formatted date
     */
    public function humanFriendly($datetimeValue, $datetimeFormat)
    {
        return Carbon::createFromFormat($datetimeFormat, $datetimeValue)->diffForHumans();
    }
}
