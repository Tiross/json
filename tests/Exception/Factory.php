<?php

namespace Tiross\json\Exception\tests\unit;

use Tiross\json\Exception\Factory as testedClass;

require_once __DIR__ . '/../../vendor/bin/atoum';

class Factory extends \atoum\test
{

    public function testMakeFrom()
    {
        $this
            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_DEPTH);
            })
                ->isInstanceOf('\Tiross\json\Exception\MaximumDepthException')
                ->hasCode(201)
                ->hasMessage('The maximum stack depth has been exceeded')

            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_STATE_MISMATCH);
            })
                ->isInstanceOf('\Tiross\json\Exception\StateMismatchException')
                ->hasCode(202)
                ->hasMessage('Invalid or malformed JSON')

            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_CTRL_CHAR);
            })
                ->isInstanceOf('\Tiross\json\Exception\ControlCharactersException')
                ->hasCode(203)
                ->hasMessage('Control character error, possibly incorrectly encoded')

            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_SYNTAX);
            })
                ->isInstanceOf('\Tiross\json\Exception\SyntaxErrorException')
                ->hasCode(204)
                ->hasMessage('Syntax error, malformed JSON')

            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_UTF8);
            })
                ->isInstanceOf('\Tiross\json\Exception\MalformedCharactersException')
                ->hasCode(205)
                ->hasMessage('Malformed UTF-8 characters, possibly incorrectly encoded')

            ->exception(function () {
                throw testedClass::makeFrom(PHP_INT_MAX);
            })
                ->isInstanceOf('\Exception')
                ->hasCode(1)
                ->hasMessage('Undefined exception')
        ;
    }

    /** @php 5.5 */
    public function testMakeFrom_Since55()
    {
        $this
            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_RECURSION);
            })
                ->isInstanceOf('\Tiross\json\Exception\RecursionException')
                ->hasCode(206)
                ->hasMessage('One or more recursive references in the value to be encoded')

            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_INF_OR_NAN);
            })
                ->isInstanceOf('\Tiross\json\Exception\InfiniteOrNotANumberException')
                ->hasCode(207)
                ->hasMessage('One or more NAN or INF values in the value to be encoded')

            ->exception(function () {
                throw testedClass::makeFrom(JSON_ERROR_UNSUPPORTED_TYPE);
            })
                ->isInstanceOf('\Tiross\json\Exception\UnsupportedTypeException')
                ->hasCode(208)
                ->hasMessage('A value of a type that cannot be encoded was given')
        ;
    }
}
