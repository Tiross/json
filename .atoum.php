<?php

use mageekguy\atoum;
use mageekguy\atoum\reports;


$report = $script->addDefaultReport();
$report->addField(new atoum\report\fields\runner\result\logo());

$cloverWriter = new atoum\writers\file('./build/logs/clover.xml');
$cloverReport = new atoum\reports\asynchronous\clover();
$cloverReport->addWriter($cloverWriter);

$runner->addReport($cloverReport);

$testGenerator = new atoum\test\generator();
$script->getRunner()->addTestsFromDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'tests');
