<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json;

// Patch pour l'utilisation sous PHP 5.3

/** @ignore */
if (!defined('JSON_BIGINT_AS_STRING')) {
    define('JSON_BIGINT_AS_STRING', 0);
}

/** @ignore */
if (!defined('JSON_PRETTY_PRINT')) {
    define('JSON_PRETTY_PRINT', 0);
}

/** @ignore */
if (!defined('JSON_UNESCAPED_SLASHES')) {
    define('JSON_UNESCAPED_SLASHES', 0);
}

/** @ignore */
if (!defined('JSON_UNESCAPED_UNICODE')) {
    define('JSON_UNESCAPED_UNICODE', 0);
}

/** @ignore */
if (!defined('JSON_ERROR_RECURSION')) {
    define('JSON_ERROR_RECURSION', 0);
}

/** @ignore */
if (!defined('JSON_ERROR_INF_OR_NAN')) {
    define('JSON_ERROR_INF_OR_NAN', 0);
}

/** @ignore */
if (!defined('JSON_ERROR_UNSUPPORTED_TYPE')) {
    define('JSON_ERROR_UNSUPPORTED_TYPE', 0);
}



/**
 * JSON representation made easy with non UTF8 values
 *
 * This class uses build-in JSON function provided by PHP, adding little functionnality.
 *
 * @see http://php.net/manual/en/book.json.php JSON on PHP.net
 * @see http://json.org/ JSON.org
 * @author Tiross
 */
class JSON
{
    /**
     * All `<` and `>` are converted to `\u003C` and `\u003E`.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-hex-tag Doc PHP.net
     * @since PHP 5.3
     * @var integer
     */
    const HEX_TAG = JSON_HEX_TAG;

    /**
     * All &s are converted to `\u0026`.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-hex-amp Doc PHP.net
     * @since PHP 5.3
     * @var integer
     */
    const HEX_AMP = JSON_HEX_AMP;

    /**
     * All `"` are converted to `\u0022`.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-hex-quot Doc PHP.net
     * @since PHP 5.3
     * @var integer
     */
    const HEX_QUOT = JSON_HEX_QUOT;

    /**
     * All `'` are converted to `\u0027`.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-hex-apos Doc PHP.net
     * @since PHP 5.3
     * @var integer
     */
    const HEX_APOS = JSON_HEX_APOS;

    /**
     * Encodes numeric strings as numbers.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-numeric-check Doc PHP.net
     * @since PHP 5.3.3
     * @var integer
     */
    const NUMERIC_CHECK = JSON_NUMERIC_CHECK;

    /**
     * Encodes large integers as their original string value.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-bigint-as-string Doc PHP.net
     * @since PHP 5.4
     * @var integer
     */
    const BIGINT_AS_STRING = JSON_BIGINT_AS_STRING;

    /**
     * Outputs an object rather than an array when a non-associative array is used.
     *
     * Especially useful when the recipient of the output is expecting an object and the array is empty.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-force-object Doc PHP.net
     * @since PHP 5.3
     * @var integer
     */
    const FORCE_OBJECT = JSON_FORCE_OBJECT;

    /**
     * Use whitespace in returned data to format it.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-pretty-print Doc PHP.net
     * @since PHP 5.4
     * @var integer
     */
    const PRETTY_PRINT = JSON_PRETTY_PRINT;

    /**
     * Don't escape `/`.
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-unescaped-slashes Doc PHP.net
     * @since PHP 5.4
     * @var integer
     */
    const UNESCAPED_SLASHES = JSON_UNESCAPED_SLASHES;

    /**
     * Encode multibyte Unicode characters literally (default is to escape as `\uXXXX`).
     *
     * @see http://php.net/manual/en/json.constants.php#constant.json-unescaped-unicode Doc PHP.net
     * @since PHP 5.4
     * @var integer
     */
    const UNESCAPED_UNICODE = JSON_UNESCAPED_UNICODE;

    /**
     * Force encoding to UTF8.
     * @var integer
     */
    const UTF8_ENCODE = 2048;

    /**
     * Options passed to instance
     * @var integer
     */
    protected $options = 0;

    /**
     * Do we want to re-encode values in UTF8
     * @var boolean
     */
    protected $utf8Encode = false;

    /**
     * Maximum depth
     * @var integer
     */
    protected $maxDepth = 0;

    /**
     * Create a new instance of json
     */
    public function __construct()
    {
        $this->setDefaults();
    }

    /**
     * Define defaults options
     */
    public function setDefaults()
    {
        $this->options = 0;
        $this->utf8Encode = false;
        $this->maxDepth = 512;

        return $this;
    }

    public function setOptions($options)
    {
        $this->options = $options | ~static::UTF8_ENCODE;
        $this->convertToUtf8($options & static::UTF8_ENCODE);

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function convertToUtf8($mode)
    {
        $this->utf8Encode = !!$mode;

        return $this;
    }

    public function setDepth($depth)
    {
        $this->maxDepth = (int) $depth;

        return $this;
    }

    public function getDepth()
    {
        return $this->maxDepth;
    }

    public function __call($method, $args)
    {
        $add = !!$args[0];

        $constant = preg_replace('`([A-Z])`', '_$1', $method);
        $constant = '\Tiross\json\JSON::' . strtoupper($constant);

        if (defined($constant)) {
            if ($add) {
                $this->options |= constant($constant);
            } else {
                $this->options &= ~constant($constant);
            }
        }

        return $this;
    }

    /**
     * Returns the JSON representation of a value
     *
     * @see http://php.net/manual/en/function.json-encode.php Doc PHP.net
     * @param  mixed   $value   The value being encoded.
     * @param  integer $options Bitmask using class constants
     * @return string           Returns a JSON encoded string
     * @throws Tiross\json\Exception\MalformedCharactersException If the value is not in UTF8 (only on PHP >= 5.5)
     */
    public function encode($value, $options = 0)
    {
        $opts    = $this->getOptions() | $options;
        $encode  = $opts & static::UTF8_ENCODE;
        $isArray = true;

        // On encapsule dans un array pour utiliser array_walk_recursive
        if (!is_array($value)) {
            $isArray = false;
            $value   = array($value);
        }

        array_walk_recursive($value, function (&$v) use ($encode) {
            if ($encode && !is_object($v)) {
                $v = utf8_encode($v);

            } elseif (is_object($v) && method_exists($v, '__toString') && !($v instanceof \JsonSerializable)) {
                if ($encode) {
                    $v = utf8_encode((string) $v);
                } else {
                    $v = (string) $v;
                }
            }
        });

        if (!$isArray) {
            $value = $value[0];
        }

        if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            $encoded = json_encode($value, $opts & ~static::UTF8_ENCODE, $this->getDepth());
        } else {
            $encoded = json_encode($value, $opts & ~static::UTF8_ENCODE);
        }

        if (false === $encoded) {
            $this->throwException(json_last_error());
        }

        return $encoded;
    }

    /**
     * Write the JSON representation of a value into a file
     *
     * If `$file` does not exist, the file is created.
     * Otherwise, the existing file is overwritten,
     *
     * @param  mixed   $value   The value being encoded.
     * @param  string  $file    Path to the file where to write the data.
     * @param  integer $options Bitmask using class constants.
     * @return boolean
     */
    public function encodeToFile($json, $file, $options = 0)
    {
        return file_put_contents($file, $this->encode($json, $options)) !== false;
    }


    /**
     * Decodes a JSON string
     *
     * @see http://php.net/manual/en/function.json-decode.php Doc PHP.net
     * @param  string  $json    The json string being decoded.
     * @param  integer $options Bitmask of JSON decode options.
     *   Currently only `JSON_BIGINT_AS_STRING` is supported (default is to cast large integers as floats).
     * @param  boolean $assoc   When `TRUE`, returned objects will be converted into associative arrays.
     * @return mixed
     */
    public function decode($json, $options = 0, $assoc = false)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            $decoded = json_decode($json, $assoc, 512, $this->getOptions() | $options);
        } else {
            $decoded = json_decode($json, $assoc, 128);
        }

        if (false === $decoded && 'false' !== $json) {
            $this->throwException(json_last_error());
        }

        return $decoded;
    }

    /**
     * Decodes a JSON string into associative array
     *
     * This method is a shortcut for `$this->decode($json, $options, true)`.
     *
     * @see JSON::decode() JSON::decode()
     * @param  string  $json    The json string being decoded.
     * @param  integer $options Bitmask of JSON decode options.
     *   Currently only `JSON_BIGINT_AS_STRING` is supported (default is to cast large integers as floats).
     * @return mixed
     */
    public function decodeToArray($json, $options = 0)
    {
        return $this->decode($json, $options, true);
    }

    /**
     * Decodes a JSON string into object
     *
     * This method is a shortcut for `$this->decode($json, $options, false)`.
     *
     * @see JSON::decode() JSON::decode()
     * @param  string  $json    The json string being decoded.
     * @param  integer $options Bitmask of JSON decode options.
     *   Currently only `JSON_BIGINT_AS_STRING` is supported (default is to cast large integers as floats).
     * @return mixed
     */
    public function decodeToObject($json, $options = 0)
    {
        return $this->decode($json, $options, false);
    }

    /**
     * Decodes a JSON string from file
     *
     * This method is a shortcut for `$this->decode(file_get_contents($file), $options)`.
     *
     * @see JSON::decode() JSON::decode()
     * @param  string  $file    Path to the file where to write the data.
     * @param  integer $options Bitmask of JSON decode options.
     *   Currently only `JSON_BIGINT_AS_STRING` is supported (default is to cast large integers as floats).
     * @throws Exception\FileNotFoundException Thrown when $file is not a file
     * @return mixed
     */
    public function decodeFile($file, $options = 0)
    {
        if (!is_file($file)) {
            throw new Exception\FileNotFoundException(sprintf('File "%s" does not exist', $file), 101);
        }

        return $this->decode(file_get_contents($file), $options);
    }

    protected function throwException($errorCode)
    {
        $exception = 'Exception';
        $message   = 'Undefined exception';
        $code      = 1;

        switch ($errorCode) {
            case JSON_ERROR_DEPTH:
                $message   = 'The maximum stack depth has been exceeded';
                $code = 201;
                break;

            case JSON_ERROR_STATE_MISMATCH:
                $message   = 'Invalid or malformed JSON';
                $code = 202;
                break;

            case JSON_ERROR_CTRL_CHAR:
                $message   = 'Control character error, possibly incorrectly encoded';
                $code = 203;
                break;

            case JSON_ERROR_SYNTAX:
                $message   = 'Syntax error, malformed JSON';
                $code = 204;
                break;

            case JSON_ERROR_UTF8:
                $exception = 'Tiross\json\Exception\MalformedCharactersException';
                $message   = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                $code = 205;
                break;

            case JSON_ERROR_RECURSION:
                $message   = 'One or more recursive references in the value to be encoded';
                $code = 206;
                break;

            case JSON_ERROR_INF_OR_NAN:
                $message   = 'One or more NAN or INF values in the value to be encoded';
                $code = 207;
                break;

            case JSON_ERROR_UNSUPPORTED_TYPE:
                $message   = 'A value of a type that cannot be encoded was given';
                $code = 208;
                break;
        }

        throw new $exception($message, $code);
    }
}
