<?php

namespace App\Library;

/**
 * Class Util
 * @package App\Library
 */
trait Utils
{
    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @return bool|string
     */
    public function getCurrentDateTime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @return bool|string
     */
    public function getCurrentDate()
    {
        return date('Y-m-d');
    }

    /**
     * @param \DateTime $dateTime
     * @param string $format
     * @return string
     */
    public function formatDateTime(\DateTime $dateTime, $format = 'Y-m-d H:i:s')
    {
        return $dateTime->format($format);
    }
}
