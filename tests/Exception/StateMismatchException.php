<?php

namespace Tiross\json\Exception\tests\unit;

require_once __DIR__ . '/../../vendor/bin/atoum';

class StateMismatchException extends \atoum\test
{
    public function testClass()
    {
        $this
            ->class('\Tiross\json\Exception\StateMismatchException')
                ->isSubclassOf('\InvalidArgumentException')
                ->implements('\Tiross\json\Exception\ExceptionInterface')
        ;
    }
}
