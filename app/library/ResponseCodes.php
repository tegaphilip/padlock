<?php

namespace App\Library;

/**
 * Class ResponseCodes
 * @package App\Library
 */
class ResponseCodes
{
    const METHOD_NOT_IMPLEMENTED = 'method_not_implemented';
    const INTERNAL_SERVER_ERROR = 'internal_server_error';
    const UNEXPECTED_ERROR = 'unexpected_error';
    const AUTH_ACCESS_TOKEN_REQUIRED = 'E0005';
    const INVALID_PARAMETERS = 'invalid_parameters';
    const RECORD_NOT_FOUND = 'not_found';
    const INVALID_AUTHENTICATION_ERROR = 'E0009';
    const SAVE_ERROR = 'E0010';
    const UPDATE_ERROR = 'E0011';
}
