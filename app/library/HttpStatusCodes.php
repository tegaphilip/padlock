<?php

namespace App\Library;

/**
 * Class HttpStatusCodes
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @package App\Library
 */
class HttpStatusCodes
{
    /**
     * 1xx Informational
     */
    const HTTP_100 = 'Continue';
    const HTTP_101 = 'Switching Protocols';
    const HTTP_102 = 'Processing';

    /**
     * 2xx Success
     */
    const HTTP_200 = 'OK';
    const HTTP_201 = 'Created';
    const HTTP_202 = 'Accepted';
    const HTTP_203 = 'Non-Authoritative Information';
    const HTTP_204 = 'No Content';
    const HTTP_205 = 'Reset Content';
    const HTTP_206 = 'Partial Content';
    const HTTP_207 = 'Multi-Status';
    const HTTP_208 = 'Already Reported';
    const HTTP_226 = 'IM Used';


    /**
     * 3xx Redirection
     */
    const HTTP_300 = 'Multiple Choices';
    const HTTP_301 = 'Moved Permanently';
    const HTTP_302 = 'Found';
    const HTTP_303 = 'See Other';
    const HTTP_304 = 'Not Modified';
    const HTTP_305 = 'Use Proxy';
    const HTTP_306 = 'Switch Proxy';
    const HTTP_307 = 'Temporary Redirect';
    const HTTP_308 = 'Permanent Redirect';

    /**
     * 4xx Client Error
     */
    const HTTP_400 = 'Bad Request';
    const HTTP_401 = 'Unauthorized';
    const HTTP_402 = 'Payment Required';
    const HTTP_403 = 'Forbidden';
    const HTTP_404 = 'Not Found';
    const HTTP_405 = 'Method Not Allowed';
    const HTTP_406 = 'Not Acceptable';
    const HTTP_407 = 'Proxy Authentication Required';
    const HTTP_408 = 'Request Timeout';
    const HTTP_409 = 'Conflict';
    const HTTP_410 = 'Gone';
    const HTTP_411 = 'Length Required';
    const HTTP_412 = 'Precondition Failed';
    const HTTP_413 = 'Request Entity Too Large';
    const HTTP_414 = 'Request-URI Too Long';
    const HTTP_415 = 'Unsupported Media Type';
    const HTTP_416 = 'Requested Range Not Satisfiable';
    const HTTP_417 = 'Expectation Failed';
    const HTTP_418 = "I'm a teapot";
    const HTTP_419 = 'Authentication Timeout';
    const HTTP_420 = 'Method Failure';
    const HTTP_422 = 'Unprocessable Entity';
    const HTTP_423 = 'Locked';
    const HTTP_424 = 'Failed Dependency';
    const HTTP_426 = 'Upgrade Required';
    const HTTP_428 = 'Precondition Required';
    const HTTP_429 = 'Too Many Requests';
    const HTTP_431 = 'Request Header Fields Too Large';
    const HTTP_440 = 'Login Timeout';
    const HTTP_444 = 'No Response';
    const HTTP_449 = 'Retry With';
    const HTTP_450 = 'Blocked by Windows Parental Controls';
    const HTTP_451 = 'Unavailable For Legal Reasons';
    const HTTP_494 = 'Request Header Too Large'; // nginx
    const HTTP_495 = 'Cert Error'; // nginx
    const HTTP_496 = 'No Cert'; // nginx
    const HTTP_497 = 'HTTP to HTTPS'; // nginx
    const HTTP_498 = 'Token expired/invalid'; // Esri
    const HTTP_499 = 'Client Closed Request'; // Nginx

    /**
     * 5xx Server Error
     */
    const HTTP_500 = 'Internal Server Error';
    const HTTP_501 = 'Not Implemented';
    const HTTP_502 = 'Bad Gateway';
    const HTTP_503 = 'Service Unavailable';
    const HTTP_504 = 'Gateway Timeout';
    const HTTP_505 = 'HTTP Version Not Supported';
    const HTTP_506 = 'Variant Also Negotiates';
    const HTTP_507 = 'Insufficient Storage';
    const HTTP_508 = 'Loop Detected';
    const HTTP_509 = 'Bandwith Limit Exceeded';
    const HTTP_510 = 'Not Extended';
    const HTTP_511 = 'Network Authentication Required';
    const HTTP_598 = 'Network read timeout error';
    const HTTP_599 = 'Network connect timeout error';

    const BAD_REQUEST_CODE = 400;
    const INTERNAL_SERVER_ERROR_CODE = 500;
    const OK_CODE = 200;
    const NOT_FOUND_CODE = 404;
    const UNAUTHORIZED_CODE = 401;

    /**
     * Get the HTTP status message for the specified HTTP status code
     * @param $code
     * @return mixed
     */
    public static function getMessage($code)
    {
        return constant('self::HTTP_' . $code);
    }
}
