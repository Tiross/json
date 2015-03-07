<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * One or more NAN or INF values in the value to be encoded
 *
 * @author Tiross
 */
class InfiniteOrNotANumberException extends \InvalidArgumentException implements ExceptionInterface
{
}
