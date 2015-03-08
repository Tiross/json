<?php

namespace Tiross\json\Exception\tests\unit;

require_once __DIR__ . '/../../vendor/bin/atoum';

class UnkownMethodException extends \atoum\test
{
    public function testClass()
    {
        $this
            ->class('\Tiross\json\Exception\UnkownMethodException')
                ->isSubclassOf('\BadMethodCallException')
                ->implements('\Tiross\json\Exception\ExceptionInterface')
        ;
    }
}
