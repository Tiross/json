<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * The maximum stack depth has been exceeded
 *
 * @author Tiross
 */
class MaximumDepthException extends \InvalidArgumentException implements ExceptionInterface
{
}
