<?php

namespace App\Library;

use \Phalcon\Security;

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
     * Gets value from array or object
     * Copied from Yii2 framework
     * @link http://www.yiiframework.com/
     * @copyright Copyright (c) 2008 Yii Software LLC
     * @license http://www.yiiframework.com/license/
     * @param      $array
     * @param      $key
     * @param null $default
     * @return null
     * @author Qiang Xue <qiang.xue@gmail.com>
     * @author Adegoke Obasa <goke@cottacush.com>
     * @author Rotimi Akintewe <rotimi.akintewe@gmail.com>
     */
    public function getValue($array, $key, $default = null)
    {
        if (!isset($array)) {
            return $default;
        }

        if ($key instanceof \Closure) {
            return $key($array, $default);
        }
        if (is_array($key)) {
            $lastKey = array_pop($key);
            foreach ($key as $keyPart) {
                $array = static::getValue($array, $keyPart);
            }
            $key = $lastKey;
        }
        if (is_array($array) && array_key_exists($key, $array)) {
            return $array[$key];
        }
        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getValue($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }

        if (is_object($array) && property_exists($array, $key)) {
            return $array->{$key};
        } elseif (is_array($array)) {
            return array_key_exists($key, $array) ? $array[$key] : $default;
        } else {
            return $default;
        }
    }

    /**
     * Generates a unique string of the given length
     * @author Adegoke Obasa <goke@cottacush.com>
     * @param int $length
     * @return string
     */
    public function generateUniqueId($length = 25)
    {
        return bin2hex(openssl_random_pseudo_bytes($length, $strong));
    }

    /**
     * Convert all objects to associative arrays
     * @author Tega Oghenekohwo <tega@cottacush.com>
     *
     * @source http://stackoverflow.com/questions/2476876/how-do-i-convert-an-object-to-an-array
     *
     * @param $obj
     * @return array
     */
    public function objectToArray($obj)
    {
        if (is_object($obj)) {
            $obj = (array)$obj;
        }

        if (is_array($obj)) {
            $new = [];
            foreach ($obj as $key => $val) {
                $new[$key] = self::objectToArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }

    /**
     * Check if string has white space
     * @param $string
     * @return int
     */
    public static function hasWhiteSpace($string)
    {
        return preg_match('/\s/', $string);
    }

    /**
     * Performs one-way encryption of a user's password using PHP's bcrypt
     *
     * @param string $rawPassword the password to be encrypted
     * @return bool|string
     */
    public static function encryptPassword($rawPassword)
    {
        $security = new Security();
        return $security->hash($rawPassword);
    }


    /**
     * Verify that password entered will match the hashed password
     *
     * @param string $rawPassword the user's raw password
     * @param string $dbHash the hashed password that was saved
     * @return bool
     */
    public static function verifyPassword($rawPassword, $dbHash)
    {
        $security = new Security();
        return $security->checkHash($rawPassword, $dbHash);
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
