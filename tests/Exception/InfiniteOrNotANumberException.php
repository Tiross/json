<?php

namespace Tiross\json\Exception\tests\unit;

require_once __DIR__ . '/../../vendor/bin/atoum';

class InfiniteOrNotANumberException extends \atoum\test
{
    public function testClass()
    {
        $this
            ->class('\Tiross\json\Exception\InfiniteOrNotANumberException')
                ->isSubclassOf('\InvalidArgumentException')
                ->implements('\Tiross\json\Exception\ExceptionInterface')
        ;
    }
}
