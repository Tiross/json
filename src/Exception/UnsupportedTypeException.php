<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * A value of a type that cannot be encoded was given
 *
 * @author Tiross
 */
class UnsupportedTypeException extends \InvalidArgumentException implements ExceptionInterface
{
}
