<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * Control character error, possibly incorrectly encoded
 *
 * @author Tiross
 */
class ControlCharactersException extends \InvalidArgumentException implements ExceptionInterface
{
}
