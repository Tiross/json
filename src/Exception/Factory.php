<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * One or more recursive references in the value to be encoded
 * @php 5.5.0
 * @ignore
 */
if (!defined('JSON_ERROR_RECURSION')) {
    define('JSON_ERROR_RECURSION', 0);
}

/**
 * One or more NAN or INF values in the value to be encoded
 * @php 5.5.0
 * @ignore
 */
if (!defined('JSON_ERROR_INF_OR_NAN')) {
    define('JSON_ERROR_INF_OR_NAN', 0);
}

/**
 * A value of a type that cannot be encoded was given
 * @php 5.5.0
 * @ignore
 */
if (!defined('JSON_ERROR_UNSUPPORTED_TYPE')) {
    define('JSON_ERROR_UNSUPPORTED_TYPE', 0);
}


/**
 * Exception factory
 *
 * @author Tiross
 */
class Factory
{
    public static function makeFrom($errorCode)
    {
        $exception = 'Exception';
        $message   = 'Undefined exception';
        $code      = 1;

        switch ($errorCode) {
            case JSON_ERROR_DEPTH:
                $exception = '\Tiross\json\Exception\MaximumDepthException';
                $message   = 'The maximum stack depth has been exceeded';
                $code = 201;
                break;

            case JSON_ERROR_STATE_MISMATCH:
                $exception = '\Tiross\json\Exception\StateMismatchException';
                $message   = 'Invalid or malformed JSON';
                $code = 202;
                break;

            case JSON_ERROR_CTRL_CHAR:
                $exception = '\Tiross\json\Exception\ControlCharactersException';
                $message   = 'Control character error, possibly incorrectly encoded';
                $code = 203;
                break;

            case JSON_ERROR_SYNTAX:
                $exception = '\Tiross\json\Exception\SyntaxErrorException';
                $message   = 'Syntax error, malformed JSON';
                $code = 204;
                break;

            case JSON_ERROR_UTF8:
                $exception = '\Tiross\json\Exception\MalformedCharactersException';
                $message   = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                $code = 205;
                break;

            case JSON_ERROR_RECURSION:
                $exception = '\Tiross\json\Exception\RecursionException';
                $message   = 'One or more recursive references in the value to be encoded';
                $code = 206;
                break;

            case JSON_ERROR_INF_OR_NAN:
                $exception = '\Tiross\json\Exception\InfiniteOrNotANumberException';
                $message   = 'One or more NAN or INF values in the value to be encoded';
                $code = 207;
                break;

            case JSON_ERROR_UNSUPPORTED_TYPE:
                $exception = '\Tiross\json\Exception\UnsupportedTypeException';
                $message   = 'A value of a type that cannot be encoded was given';
                $code = 208;
                break;
        }

        return new $exception($message, $code);
    }
}
