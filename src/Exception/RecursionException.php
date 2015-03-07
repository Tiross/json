<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * One or more recursive references in the value to be encoded
 *
 * @author Tiross
 */
class RecursionException extends \InvalidArgumentException implements ExceptionInterface
{
}
