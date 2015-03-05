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
                ->isEqualTo(512)
        ;
    }

    /**
     * @dataProvider encodeProvider
     */
    public function testEncode($value, $options, $method)
    {
        $this
            ->if($this->newTestedInstance)
            ->and($this->function->json_encode = $encoded = uniqid())
            ->then
                ->assert
                    ->string($this->testedInstance->encode($value, $options))
                        ->isIdenticalTo($encoded)
                    ->function('json_encode')
                        ->wasCalledWithIdenticalArguments($value, $options)
                            ->once

                ->assert
                    ->string($this->testedInstance->$method(true)->encode($value))
                        ->isIdenticalTo($encoded)
                    ->function('json_encode')
                        ->wasCalledWithIdenticalArguments($value, $options)
                            ->once
        ;
    }

    public function testEncodeObjectCastedToString()
    {
        $this
            ->given($this->newTestedInstance)
            ->and($this->function->json_encode = $encoded = uniqid())
            ->if($obj = new TestObjectCastedToString)
            ->then
                ->string($this->testedInstance->encode($obj))
                    ->isIdenticalTo($encoded)
                ->function('json_encode')
                    ->wasCalledWithIdenticalArguments((string) $obj)
                        ->once
        ;
    }

    /** @php 5.4 */
    public function testEncodeJsonisableObject()
    {
        $this
            ->given($this->newTestedInstance)
            ->if($obj = new TestObjectJsonCompatible)
            ->then
                ->string($this->testedInstance->encode($obj))
                    ->isIdenticalTo(json_encode($obj))
        ;
    }

    /** @php 5.4 */
    public function testEncodeResolutionOrder()
    {
        $this
            ->given($this->newTestedInstance)
            ->if($obj = new TestObjectBoth)
            ->then
                ->string($this->testedInstance->encode($obj))
                    ->isIdenticalTo(json_encode($obj))
                    ->isNotIdenticalTo(json_encode((string) $obj))
        ;
    }

    public function testEncodeInUTF()
    {
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

    /**
     * @dataProvider encodeProvider
     */
    public function testEncodeToFile($json, $options, $method)
    {
        $this
            ->given($this->newTestedInstance)
            ->if($this->function->file_put_contents = true)
            ->then
                ->boolean($this->testedInstance->encodeToFile($json, $file = uniqid(), $options))
                    ->isTrue
                ->function('file_put_contents')
                    ->wasCalledWithIdenticalArguments($file, $this->testedInstance->encode($json, $options))
                    ->once
        ;
    }

    /** @php 5.4 */
    public function testDecode()
    {
        $this
            ->given($this->newTestedInstance)
            ->if($this->function->json_decode = $decoded = uniqid())
            ->and($defaultAssoc = false)
            ->and($defaultDepth = 512)
            ->and($defaultOptions = 0)
            ->then
                ->assert('no options')
                    ->string($this->testedInstance->decode($json = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($json, $defaultAssoc, $defaultDepth, $defaultOptions)
                        ->once

                ->assert('force associative with argument')
                    ->string($this->testedInstance->decode($json = uniqid(), $options = 0, $assoc = true))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithArguments($json, $assoc, $defaultDepth, $options)
                        ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecode53()
    {
        $this
            ->given($this->newTestedInstance)
            ->if($this->function->json_decode = $decoded = uniqid())
            ->and($defaultAssoc = false)
            ->and($defaultDepth = 128)
            ->then
                ->assert('no options')
                    ->string($this->testedInstance->decode($json = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($json, $defaultAssoc, $defaultDepth)
                        ->once

                ->assert('force associative with argument')
                    ->string($this->testedInstance->decode($json = uniqid(), $options = 0, $assoc = true))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithArguments($json, $assoc, $defaultDepth)
                        ->once
        ;
    }

    /**
     * @dataProvider decodeProvider
     */
    public function testDecodeToArray($type, $value, $options)
    {
        if ($type == 'object') {
            $type = 'array';
        }

        $this
            ->given($this->newTestedInstance)
            ->then
                ->$type($this->testedInstance->decodeToArray($value, $options))
                    ->isIdenticalTo($this->testedInstance->decode($value, $options, true))
        ;
    }

    /**
     * @dataProvider decodeProvider
     */
    public function testDecodeToObject($type, $value, $options)
    {
        $this
            ->given($this->newTestedInstance)
            ->then
                ->$type($this->testedInstance->decodeToObject($value, $options))
                    ->isEqualTo($this->testedInstance->decode($value, $options, false))
        ;
    }

    public function testDecodeFile()
    {
        $this
            ->given($this->function->is_file = true)
            ->and($this->function->file_get_contents = true)
            ->if($this->newTestedInstance->decodeFile($file = uniqid()))
            ->then
                ->function('is_file')
                    ->wasCalledWithIdenticalArguments($file)
                    ->once
                ->function('file_get_contents')
                    ->wasCalledWithIdenticalArguments($file)
                    ->once

            ->if($this->function->is_file = false)
            ->then
                ->exception(function () use ($file) {
                    $this->newTestedInstance->decodeFile($file);
                })
                    ->isInstanceOf('\Tiross\json\Exception\FileNotFoundException')
                    ->hasCode(101)
                    ->hasMessage(sprintf('File "%s" does not exist', $file))
        ;
    }

    /** @php 5.5 */
    public function testEncodeNonUTF8()
    {
        $this
            ->exception(function () {
                $this->newTestedInstance->encode("\xB1\x31");
            })
                ->isInstanceOf('\Tiross\json\Exception\MalformedCharactersException')
                ->hasCode(205)
                ->hasMessage('Malformed UTF-8 characters, possibly incorrectly encoded')
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

    public function encodeProvider()
    {
        $php53 = array(
            array('test', 0, ''),
            array(array(1, 2), 0, ''),
            array(array('foo', 'bar'), 0, ''),
            array('<test>', testedClass::HEX_TAG, 'hexTag'),
            array('&nbsp;', testedClass::HEX_AMP, 'hexAmp'),
            array('"\'', testedClass::HEX_QUOT, 'hexQuot'),
            array('"\'', testedClass::HEX_APOS, 'hexApos'),
            array('123', testedClass::NUMERIC_CHECK, 'numericCheck'),
        );

        $php54 = array(
            array(PHP_INT_MAX, testedClass::BIGINT_AS_STRING, 'bigintAsString'),
            array(array(1, 2), testedClass::FORCE_OBJECT, 'forceObject'),
            array(' /!\\ ', testedClass::UNESCAPED_SLASHES, 'unescapedSlashes'),
            array('\u00e9', testedClass::UNESCAPED_UNICODE, 'unescapedUnicode'),
            array(array('foo', 'bar'), testedClass::PRETTY_PRINT, 'prettyPrint'),
        );

        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return array_merge($php53, $php54);
        } else {
            return $php53;
        }
    }

    public function decodeProvider()
    {

        $scalar = array(
            array('string', '"test"', 0),
            array('boolean', 'true', 0),
            array('boolean', 'false', 0),
            array('variable', 'null', 0),
            array('integer', '123', 0),
            array('float', '1.23', 0),
        );

        $array = array(
            array('array', '[1,2,3]', 0),
            array('object', '{"foo":"bar"}', 0),
            array('object', '{"foo":["bar","baz"]}', 0),
            array('object', '{"foo":[1,2,3]}', 0),
            array('array', '[{"foo":[1]},{"bar":[2]}]', 0),
        );

        $php54 = array(
            array('string', '"1234567890"', \JSON_BIGINT_AS_STRING),
        );

        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return array_merge($scalar, $array, $php54);
        } else {
            return array_merge($scalar, $array);
        }
    }
}


class TestObjectCastedToString
{
    protected $a = 'Transtyped OK';
    protected $b = 'Transtyped NOK';

    public function __toString()
    {
        return $this->a;
    }
}

class TestObjectJsonCompatible implements \JsonSerializable
{
    protected $c = 'Serializable OK';
    protected $d = 'Serializable NOK';

    public function jsonSerialize()
    {
        return $this->c;
    }
}

class TestObjectBoth implements \JsonSerializable
{
    protected $a = 'Transtyped OK';
    protected $b = 'Transtyped NOK';
    protected $c = 'Serializable OK';
    protected $d = 'Serializable NOK';

    public function __toString()
    {
        return $this->a;
    }

    public function jsonSerialize()
    {
        return $this->c;
    }
}
