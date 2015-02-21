<?php

use \mageekguy\atoum;

$report = $script->addDefaultReport();
$report->addField(new atoum\report\fields\runner\result\logo());

$testGenerator = new atoum\test\generator();
$script->getRunner()->addTestsFromDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'tests');
