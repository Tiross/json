<?php

namespace Tiross\json\tests\unit;

use Tiross\json\JSON as testedClass;

require_once __DIR__ . '/../vendor/bin/atoum';
require_once __DIR__ . '/JsonSerializable.php'; // Test on 5.3 hack


class JSON extends \atoum\test
{
    /**
     * @dataProvider constantProvider
     */
    public function testConstant($suffix)
    {
        $this
            ->integer(constant('\Tiross\json\JSON::' . $suffix))
                ->isIdenticalTo(constant('JSON_' . $suffix))
        ;
    }

    public function test__construct()
    {
        $this
            ->integer($this->newTestedInstance->getOptions())
                ->isZero
            ->integer($this->testedInstance->getDepth())
                ->IsIdenticalTo(512)
        ;
    }

    public function test__get()
    {
        $this
            ->if($this->newTestedInstance)
            ->then
                ->object($this->testedInstance->truc)
                    ->isTestedInstance
                ->object($this->testedInstance->bidule)
                    ->isTestedInstance
        ;
    }

    public function test__call()
    {
        $this
            ->if($this->newTestedInstance)
            ->then
                ->object($this->testedInstance->truc())
                    ->isTestedInstance
                ->object($this->testedInstance->bidule())
                    ->isTestedInstance
        ;
    }

    public function test__callStatic()
    {
        $this
            ->exception(function () {
                testedClass::truc();
            })
                ->isInstanceOf('\Tiross\json\Exception\UnkownMethodException')
                ->hasCode(103)
                ->hasMessage('Call to undefined method Tiross\json\JSON::truc()')
        ;
    }

    public function testSetDefaults()
    {
        $this
            ->if($this->newTestedInstance->setOptions(rand(0, PHP_INT_MAX))->setDepth(0))
            ->then
                ->object($this->testedInstance->setDefaults())
                    ->isTestedInstance

                ->integer($this->testedInstance->getOptions())
                    ->isZero

                ->integer($this->testedInstance->getDepth())
                    ->IsIdenticalTo(512)

            ->if($this->newTestedInstance->setOptions(rand(0, PHP_INT_MAX))->setDepth(0))
            ->then
                ->object($this->testedInstance->setDefaults)->isTestedInstance
                ->integer($this->testedInstance->getOptions())->isZero

            ->if($this->newTestedInstance->setOptions(rand(0, PHP_INT_MAX))->setDepth(0))
            ->then
                ->object($this->testedInstance->SETDEFAULTS)->isTestedInstance
                ->integer($this->testedInstance->getOptions())->isZero
        ;
    }

    public function testDepth()
    {
        $this
            ->if($this->newTestedInstance)
            ->then
                ->object($this->testedInstance->setDepth($opts = rand(0, PHP_INT_MAX)))
                    ->isTestedInstance

                ->integer($this->testedInstance->getDepth())
                    ->IsIdenticalTo($opts)
        ;
    }

    public function testHexTag()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::HEX_TAG)
            ->then
                ->object($this->testedInstance->hexTag(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->hexTag(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testHexAmp()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::HEX_AMP)
            ->then
                ->object($this->testedInstance->hexAmp(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->hexAmp(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testHexQuot()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::HEX_QUOT)
            ->then
                ->object($this->testedInstance->hexQuot(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->hexQuot(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testHexApos()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::HEX_APOS)
            ->then
                ->object($this->testedInstance->hexApos(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->hexApos(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testNumericCheck()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::NUMERIC_CHECK)
            ->then
                ->object($this->testedInstance->numericCheck(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->numericCheck(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testPrettyPrint()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::PRETTY_PRINT)
            ->then
                ->object($this->testedInstance->prettyPrint(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->prettyPrint(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testUnescapedUnicode()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::UNESCAPED_UNICODE)
            ->then
                ->object($this->testedInstance->unescapedUnicode(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->unescapedUnicode(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testUnescapedSlashes()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::UNESCAPED_SLASHES)
            ->then
                ->object($this->testedInstance->unescapedSlashes(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->unescapedSlashes(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testForceObject()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::FORCE_OBJECT)
            ->then
                ->object($this->testedInstance->forceObject(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->forceObject(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testBigintAsString()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($constant = testedClass::BIGINT_AS_STRING)
            ->then
                ->object($this->testedInstance->bigintAsString(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo($constant)
                ->object($this->testedInstance->bigintAsString(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsIdenticalTo(0)
                ->integer($this->testedInstance->setOptions($constant)->getOptions())->isIdenticalTo($constant)
        ;
    }

    public function testOptions()
    {
        $this
            ->if($this->newTestedInstance)
            ->and($opts = rand(0, PHP_INT_MAX))
            ->and($optionWithConvertEncoding = $opts | testedClass::UTF8_ENCODE)
            ->and($optionWithoutConvertEncoding = $opts & ~testedClass::UTF8_ENCODE)
            ->then
                ->object($this->testedInstance->setOptions($optionWithConvertEncoding))
                    ->isTestedInstance
                ->integer($this->testedInstance->getOptions())
                    ->IsIdenticalTo($optionWithConvertEncoding)
                ->integer($this->testedInstance->getOptions)
                    ->IsIdenticalTo($optionWithConvertEncoding)
                ->integer($this->testedInstance->GETOPTIONS)
                    ->IsIdenticalTo($optionWithConvertEncoding)
                ->boolean($this->testedInstance->convertToUtf8())
                    ->isTrue

                ->object($this->testedInstance->setOptions($optionWithoutConvertEncoding))
                    ->isTestedInstance
                ->integer($this->testedInstance->getOptions())
                    ->IsIdenticalTo($optionWithoutConvertEncoding)
                ->integer($this->testedInstance->getOptions)
                    ->IsIdenticalTo($optionWithoutConvertEncoding)
                ->integer($this->testedInstance->GETOPTIONS)
                    ->IsIdenticalTo($optionWithoutConvertEncoding)
                ->boolean($this->testedInstance->convertToUtf8())
                    ->isFalse
        ;
    }

    public function testConvertToUtf8()
    {
        $this
            ->if($this->newTestedInstance)
            ->then
                ->boolean($this->testedInstance->convertToUtf8())->isFalse
                ->boolean($this->testedInstance->convertToUtf8)->isFalse
                ->boolean($this->testedInstance->CONVERTTOUTF8)->isFalse

                ->object($this->testedInstance->convertToUtf8(true))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->isIdenticalTo(testedClass::UTF8_ENCODE)
                ->boolean($this->testedInstance->convertToUtf8())->isTrue
                ->boolean($this->testedInstance->convertToUtf8)->isTrue
                ->boolean($this->testedInstance->CONVERTTOUTF8)->isTrue

                ->object($this->testedInstance->convertToUtf8(false))->isTestedInstance
                ->integer($this->testedInstance->getOptions())->IsZero
                ->boolean($this->testedInstance->convertToUtf8())->isFalse
                ->boolean($this->testedInstance->convertToUtf8)->isFalse
                ->boolean($this->testedInstance->CONVERTTOUTF8)->isFalse
        ;
    }

    /** @php 5.5 */
    public function testEncode_Since55()
    {
        $this
            ->given($this->function->json_encode = $encoded = uniqid())
            ->and($this->function->utf8_encode = $utf8 = uniqid())
            ->and($value = uniqid())

            ->if($this->newTestedInstance)
            ->and($options = $this->testedInstance->setOptions(rand(0, PHP_INT_MAX))->convertToUtf8(false)->getOptions)

            ->and($depth = $this->testedInstance->setDefaults->getDepth())

            ->assert('no options, no utf8 encode')
                ->string($this->testedInstance->encode($value))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, 0, $depth)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never

            ->assert('options as method argument, no utf8 encode')
                ->string($this->testedInstance->encode($value, $options))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, $options, $depth)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never

            ->assert('options as instance property, no utf8 encode')
                ->string($this->testedInstance->setOptions($options)->encode($value))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, $options, $depth)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never

            ->assert('options as method argument, utf8 option too')
                ->string($this->testedInstance->encode($value, $options | testedClass::UTF8_ENCODE))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($utf8, $options, $depth)
                        ->once
                ->function('utf8_encode')
                    ->wasCalledWithIdenticalArguments($value)
                        ->once

            ->assert('options as instance property, utf8 as option')
                ->string($this->testedInstance->setOptions($options)->encode($value, testedClass::UTF8_ENCODE))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($utf8, $options, $depth)
                        ->once
                ->function('utf8_encode')
                    ->wasCalledWithIdenticalArguments($value)
                        ->once

            ->assert('options and utf8 parameter as instance property')
                ->string($this->testedInstance->setOptions($options)->convertToUtf8(true)->encode($value))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($utf8, $options, $depth)
                        ->once
                ->function('utf8_encode')
                    ->wasCalledWithIdenticalArguments($value)
                        ->once
        ;
    }

    /** @php < 5.5 */
    public function testEncode_Before55()
    {
        $this
            ->given($this->function->json_encode = $encoded = uniqid())
            ->and($this->function->utf8_encode = $utf8 = uniqid())
            ->and($value = uniqid())

            ->if($this->newTestedInstance)
            ->and($options = $this->testedInstance->setOptions(rand(0, PHP_INT_MAX))->convertToUtf8(false)->getOptions)

            ->assert('options as method argument, no utf8 encode')
                ->string($this->testedInstance->encode($value, $options))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, $options)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never

            ->assert('options as instance property, no utf8 encode')
                ->string($this->testedInstance->setOptions($options)->encode($value))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, $options)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never
        ;
    }

    public function testEncode_Exception()
    {
        $this
            ->given($this->function->json_encode = false)
            ->and($obj = $this->newTestedInstance)

            ->if($this->function->json_last_error = PHP_INT_MAX)
            ->then
                ->exception(function () use ($obj) {
                    $obj->encode('');
                })
                    ->isInstanceOf('\Exception')
                    ->hasCode(1)
                    ->hasMessage('Undefined exception')

                ->function('json_last_error')
                    ->wasCalledWithoutAnyArgument()
                        ->once
        ;
    }

    /** @php 5.5 */
    public function testEncode_StaticCall_Since55()
    {
        $this
            ->given($this->function->json_encode = $encoded = uniqid())
            ->and($this->function->utf8_encode = $utf8 = uniqid())
            ->and($value = uniqid())

            ->assert('no options, no utf8 encode')
                ->string(testedClass::encode($value))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, 0, 512)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never

            ->assert('with options, no utf8 encode')
                ->string(testedClass::encode($value, $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, $options, 512)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never
        ;
    }

    /** @php < 5.5 */
    public function testEncode_StaticCall_Before55()
    {
        $this
            ->given($this->function->json_encode = $encoded = uniqid())
            ->and($this->function->utf8_encode = $utf8 = uniqid())
            ->and($value = uniqid())

            ->assert('no options, no utf8 encode')
                ->string(testedClass::encode($value))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, 0)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never

            ->assert('with options, no utf8 encode')
                ->string(testedClass::encode($value, $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($value, $options)
                        ->once
                ->function('utf8_encode')
                    ->wasCalled->never
        ;
    }

    /** @php 5.5 */
    public function testEncode_MalformedCharactersException_Since55()
    {
        $this
            ->exception(function () {
                $this->newTestedInstance->encode("\xB1\x31");
            })
                ->isInstanceOf('\Tiross\json\Exception\MalformedCharactersException')
                ->hasCode(205)
                // Message is tested in testThrowException
        ;
    }

    /**
     * @php 5.5
     * Depth option is available since 5.5
     */
    public function testEncode_MaximumDepthException_Since55()
    {
        $this
            ->exception(function () {
                $array = array(
                    'foo' => array(
                        'bar' => array(
                            'baz' => true,
                        ),
                    ),
                );

                $this->newTestedInstance->setDepth(0)->encode($array);
            })
                ->isInstanceOf('\Tiross\json\Exception\MaximumDepthException')
                ->hasCode(201)
                // Message is tested in testThrowException
        ;
    }

    public function testEncodeObjectCastedToString()
    {
        return;
        $this
            ->given($this->newTestedInstance)
            ->and($this->function->json_encode = $encoded = uniqid())
            ->and($options = $this->testedInstance->getOptions())
            ->and($depth = $this->testedInstance->getDepth())

            ->if($obj = new TestObjectCastedToString)
            ->then
                ->string($this->testedInstance->encode($obj))
                    ->isIdenticalTo($encoded)

                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments((string) $obj, $options, $depth)
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testEncodeJsonisableObject_Since54()
    {
        return;
        $this
            ->given($this->newTestedInstance)
            ->and($options = $this->testedInstance->getOptions())
            ->and($depth = $this->testedInstance->getDepth())
            ->and($this->function->json_encode = $encoded = uniqid())

            ->if($obj = new TestObjectJsonCompatible)
            ->then
                ->string($this->testedInstance->encode($obj))
                    ->isIdenticalTo($encoded)

                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($obj, $options, $depth)
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testEncodeResolutionOrder_Since54()
    {
        return;
        $this
            ->given($this->newTestedInstance)
            ->and($options = $this->testedInstance->getOptions())
            ->and($depth = $this->testedInstance->getDepth())
            ->and($this->function->json_encode = $encoded = uniqid())

            ->if($obj = new TestObjectBoth)
            ->then
                ->string($this->testedInstance->encode($obj))
                    ->isIdenticalTo($encoded)

                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments($obj, $options, $depth)
                        ->once
        ;
    }

    public function testEncodeInUTF()
    {
        return;
        $this
            ->given($this->newTestedInstance)
            ->if($this->function->utf8_encode = $utf8 = uniqid())
            ->then

                ->assert('with string')
                    ->string($this->testedInstance->encode($text = uniqid(), testedClass::UTF8_ENCODE))
                        ->isIdenticalTo(json_encode($utf8))
                    ->function('utf8_encode')
                        ->wasCalledWithIdenticalArguments($text)
                        ->once

                ->assert('with casted to string object')
                    ->string($this->testedInstance->encode($obj = new TestObjectCastedToString, testedClass::UTF8_ENCODE))
                        ->isIdenticalTo(json_encode($utf8))
                    ->function('utf8_encode')
                        ->wasCalledWithIdenticalArguments((string) $obj)
                        ->once

                ->assert('with JsonSerializable object')
                    ->string($this->testedInstance->encode($obj = new TestObjectJsonCompatible, testedClass::UTF8_ENCODE))
                        ->isIdenticalTo(json_encode($obj))
                    ->function('utf8_encode')
                        ->never
        ;
    }

    public function testEncodeToFile()
    {
        $this
            ->given($this->newTestedInstance)
            ->if($this->function->file_put_contents = true)
            ->then
                ->boolean($this->testedInstance->encodeToFile($value = uniqid(), $file = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isTrue

                ->function('file_put_contents')
                    ->wasCalledWithIdenticalArguments($file, $this->testedInstance->encode($value, $options))
                        ->once

                // Statically
                ->boolean(testedClass::encodeToFile($value = uniqid(), $file = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isTrue

                ->function('file_put_contents')
                    ->wasCalledWithIdenticalArguments($file, testedClass::encode($value, $options))
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testDecode_Since54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())
            ->and($this->function->json_last_error = PHP_INT_MAX)

            ->if($obj = $this->newTestedInstance)

            ->assert('no options, arguments')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($options = $this->testedInstance->getOptions())
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('with options as arguments')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($options = rand(0, PHP_INT_MAX))
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid(), $options))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('with options as instance property')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($options = $this->testedInstance->setOptions(rand(0, PHP_INT_MAX))->getOptions())
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('with options both argument and property')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($this->testedInstance->setOptions($optsInstance = 1))
                ->and($optsArguments = 2)
                ->and($options = $optsInstance | $optsArguments)
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid(), $optsArguments))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('change depth')
                ->if($this->testedInstance->setDefaults->setDepth($depth = rand(0, PHP_INT_MAX)))
                ->and($options = 0)
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('test assoc')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($options = 0)
                ->and($assoc = true)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid(), $options, $assoc))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('exception')
                ->if($this->function->json_decode = false)
                ->then
                    ->exception(function () use ($obj) {
                        $obj->decode('');
                    })
                        ->isInstanceOf('\Exception')
                        ->hasCode(1)
                        ->hasMessage('Undefined exception')
        ;
    }

    /** @php < 5.4 */
    public function testDecode_Before54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())
            ->and($this->function->json_last_error = PHP_INT_MAX)

            ->if($obj = $this->newTestedInstance)

            ->assert('no options, arguments')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($options = $this->testedInstance->getOptions())
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth)
                            ->once

            ->assert('change depth')
                ->if($this->testedInstance->setDefaults->setDepth($depth = rand(0, PHP_INT_MAX)))
                ->and($options = 0)
                ->and($assoc = false)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth)
                            ->once

            ->assert('test assoc')
                ->if($depth = $this->testedInstance->setDefaults->getDepth())
                ->and($options = 0)
                ->and($assoc = true)
                ->then
                    ->string($this->testedInstance->decode($value = uniqid(), $options, $assoc))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth)
                            ->once

            ->assert('exception')
                ->if($this->function->json_decode = false)
                ->then
                    ->exception(function () use ($obj) {
                        $obj->decode('');
                    })
                        ->isInstanceOf('\Exception')
                        ->hasCode(1)
                        ->hasMessage('Undefined exception')
        ;
    }

    /** @php 5.4 */
    public function testDecodeToArray_Since54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())

            ->if($obj = $this->newTestedInstance)
            ->and($depth = $this->testedInstance->getDepth())

            ->then
                ->string($this->testedInstance->decodeToArray($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, true, $depth, $options)
                        ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecodeToArray_Before54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())

            ->if($obj = $this->newTestedInstance)
            ->and($depth = $this->testedInstance->getDepth())

            ->then
                ->string($this->testedInstance->decodeToArray($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, true, $depth) // removed $options
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testDecodeToObject_Since54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())

            ->if($obj = $this->newTestedInstance)
            ->and($depth = $this->testedInstance->getDepth())

            ->then
                ->string($this->testedInstance->decodeToObject($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, false, $depth, $options)
                        ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecodeToObject_Before54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())

            ->if($obj = $this->newTestedInstance)
            ->and($depth = $this->testedInstance->getDepth())

            ->then
                ->string($this->testedInstance->decodeToObject($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, false, $depth) // removed $options
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testDecodeFile_Since54()
    {
        $this
            ->given($this->function->is_file = true)
            ->and($this->function->file_get_contents = $fileContent = uniqid())
            ->and($this->function->json_decode = $decoded = uniqid())

            ->if($obj = $this->newTestedInstance)
            ->and($depth = $this->testedInstance->getDepth())

            ->then
                ->string($this->testedInstance->decodeFile($file = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)

                ->function('is_file')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('file_get_contents')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($fileContent, false, $depth, $options)
                        ->once

            ->if($this->function->is_file = false)
            ->then
                ->exception(function () use ($obj, $file) {
                    $obj->decodeFile($file);
                })
                    ->isInstanceOf('\Tiross\json\Exception\FileNotFoundException')
                    ->hasCode(101)
                    ->hasMessage(sprintf('File "%s" does not exist', $file))
        ;
    }

    /** @php < 5.4 */
    public function testDecodeFile_Before54()
    {
        $this
            ->given($this->function->is_file = true)
            ->and($this->function->file_get_contents = $fileContent = uniqid())
            ->and($this->function->json_decode = $decoded = uniqid())

            ->if($obj = $this->newTestedInstance)
            ->and($depth = $this->testedInstance->getDepth())

            ->then
                ->string($this->testedInstance->decodeFile($file = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)

                ->function('is_file')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('file_get_contents')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($fileContent, false, $depth) // removed $options
                        ->once

            ->if($this->function->is_file = false)
            ->then
                ->exception(function () use ($obj, $file) {
                    $obj->decodeFile($file);
                })
                    ->isInstanceOf('\Tiross\json\Exception\FileNotFoundException')
                    ->hasCode(101)
                    ->hasMessage(sprintf('File "%s" does not exist', $file))
        ;
    }

    /** @php 5.4 */
    public function testDecode_StaticCall_Since54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())
            ->and($this->function->json_last_error = PHP_INT_MAX)
            ->and($depth = 512)

            ->assert('no options, arguments')
                ->if($options = 0)
                ->and($assoc = false)
                ->then
                    ->string(testedClass::decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('with options as arguments')
                ->if($options = rand(0, PHP_INT_MAX))
                ->and($assoc = false)
                ->then
                    ->string(testedClass::decode($value = uniqid(), $options))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once

            ->assert('test assoc')
                ->if($options = 0)
                ->and($assoc = true)
                ->then
                    ->string(testedClass::decode($value = uniqid(), $options, $assoc))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth, $options)
                            ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecode_StaticCall_Before54()
    {
        $this
            ->given($this->function->json_decode = $decoded = uniqid())
            ->and($this->function->json_last_error = PHP_INT_MAX)
            ->and($depth = 512)

            ->assert('no options, arguments')
                ->if($assoc = false)
                ->then
                    ->string(testedClass::decode($value = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth)
                            ->once

            ->assert('test assoc')
                ->if($assoc = true)
                ->then
                    ->string(testedClass::decode($value = uniqid(), 0, $assoc))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($value, $assoc, $depth)
                            ->once
        ;
    }

    /** @php 5.4 */
    public function testDecodeToArray_StaticCall_Since54()
    {
        $this
            ->if($this->function->json_decode = $decoded = uniqid())
            ->then
                ->string(testedClass::decodeToArray($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, true, 512, $options)
                        ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecodeToArray_StaticCall_Before54()
    {
        $this
            ->if($this->function->json_decode = $decoded = uniqid())
            ->then
                ->string(testedClass::decodeToArray($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, true, 512) // removed $options
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testDecodeToObject_StaticCall_Since54()
    {
        $this
            ->if($this->function->json_decode = $decoded = uniqid())
            ->then
                ->string(testedClass::decodeToObject($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, false, 512, $options)
                        ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecodeToObject_StaticCall_Before54()
    {
        $this
            ->if($this->function->json_decode = $decoded = uniqid())
            ->then
                ->string(testedClass::decodeToObject($value = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)
                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($value, false, 512) // removed $options
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testDecodeFile_StaticCall_Since54()
    {
        $this
            ->if($this->function->is_file = true)
            ->and($this->function->file_get_contents = $fileContent = uniqid())
            ->and($this->function->json_decode = $decoded = uniqid())

            ->then
                ->string(testedClass::decodeFile($file = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)

                ->function('is_file')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('file_get_contents')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($fileContent, false, 512, $options)
                        ->once

            ->if($this->function->is_file = false)
            ->then
                ->exception(function () use ($file) {
                    testedClass::decodeFile($file);
                })
                    ->isInstanceOf('\Tiross\json\Exception\FileNotFoundException')
                    ->hasCode(101)
                    ->hasMessage(sprintf('File "%s" does not exist', $file))
        ;
    }

    /** @php < 5.4 */
    public function testDecodeFile_StaticCall_Before54()
    {
        $this
            ->if($this->function->is_file = true)
            ->and($this->function->file_get_contents = $fileContent = uniqid())
            ->and($this->function->json_decode = $decoded = uniqid())
            ->then
                ->string(testedClass::decodeFile($file = uniqid(), $options = rand(0, PHP_INT_MAX)))
                    ->isIdenticalTo($decoded)

                ->function('is_file')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('file_get_contents')
                    ->wasCalledWithIdenticalArguments($file)
                        ->once

                ->function('json_decode')
                    ->wasCalledWithIdenticalArguments($fileContent, false, 512) // removed $options
                        ->once

            ->if($this->function->is_file = false)
            ->then
                ->exception(function () use ($file) {
                    testedClass::decodeFile($file);
                })
                    ->isInstanceOf('\Tiross\json\Exception\FileNotFoundException')
                    ->hasCode(101)
                    ->hasMessage(sprintf('File "%s" does not exist', $file))
        ;
    }


    public function constantProvider()
    {
        $php53 = array(
            'HEX_TAG',
            'HEX_AMP',
            'HEX_QUOT',
            'HEX_APOS',
            'NUMERIC_CHECK',
        );

        $php54 = array(
            'BIGINT_AS_STRING',
            'FORCE_OBJECT',
            'UNESCAPED_SLASHES',
            'UNESCAPED_UNICODE',
            'PRETTY_PRINT',
        );

        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return array_merge($php53, $php54);
        } else {
            return $php53;
        }
    }
}


class TestObjectCastedToString
{
    public $a = 'Transtyped OK';
    public $b = 'Transtyped NOK';

    public function __toString()
    {
        return $this->a;
    }
}

class TestObjectJsonCompatible implements \JsonSerializable
{
    public $c = 'Serializable OK';
    public $d = 'Serializable NOK';

    public function jsonSerialize()
    {
        return $this->c;
    }
}

class TestObjectBoth implements \JsonSerializable
{
    public $a = 'Transtyped OK';
    public $b = 'Transtyped NOK';
    public $c = 'Serializable OK';
    public $d = 'Serializable NOK';

    public function __toString()
    {
        return $this->a;
    }

    public function jsonSerialize()
    {
        return $this->c;
    }
}
