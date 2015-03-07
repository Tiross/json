<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * Invalid or malformed JSON
 *
 * @author Tiross
 */
class StateMismatchException extends \InvalidArgumentException implements ExceptionInterface
{
}
