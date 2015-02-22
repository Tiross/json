<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * Malformed characters
 *
 * @author Tiross
 */
class MalformedCharactersException extends \InvalidArgumentException implements ExceptionInterface
{
}
