<?php

/**
 * JSON representation made easy with non UTF8 values
 *
 * @author Tiross
 */

namespace Tiross\json\Exception;

/**
 * Syntax error, malformed JSON
 *
 * @author Tiross
 */
class SyntaxErrorException extends \InvalidArgumentException implements ExceptionInterface
{
}
