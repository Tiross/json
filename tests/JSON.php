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
    public function testConstant($suffixe)
    {
        $this
            ->integer(constant('\Tiross\json\JSON::' . $suffixe))
                ->isIdenticalTo(constant('JSON_' . $suffixe))
        ;
    }

    /**
     * @dataProvider encodeProvider
     */
    public function testEncode($value, $options)
    {
        $this
            ->string(testedClass::encode($value, $options))
                ->isIdenticalTo(json_encode($value, $options))
        ;
    }

    public function testEncodeObjectCastedToString()
    {
        $this
            ->if($obj = new TestObjectCastedToString)
            ->then
                ->string(testedClass::encode($obj))
                    ->isIdenticalTo(json_encode((string) $obj))
        ;
    }

    public function testEncodeJsonisableObject()
    {
        $this
            ->if($obj = new TestObjectJsonCompatible)
            ->then
                ->string(testedClass::encode($obj))
                    ->isIdenticalTo(json_encode($obj))
        ;
    }

    public function testEncodeResolutionOrder()
    {
        $this
            ->if($obj = new TestObjectBoth)
            ->then
                ->string(testedClass::encode($obj))
                    ->isIdenticalTo(json_encode($obj))
                    ->isNotIdenticalTo(json_encode((string) $obj))
        ;
    }

    public function testEncodeInUTF()
    {
        $this
            ->if($this->function->utf8_encode = $utf8 = uniqid())
            ->then

                ->assert('with string')
                    ->string(testedClass::encode($text = uniqid(), testedClass::UTF8_ENCODE))
                        ->isIdenticalTo(json_encode($utf8))
                    ->function('utf8_encode')
                        ->wasCalledWithIdenticalArguments($text)
                        ->once

                ->assert('with casted to string object')
                    ->string(testedClass::encode($obj = new TestObjectCastedToString, testedClass::UTF8_ENCODE))
                        ->isIdenticalTo(json_encode($utf8))
                    ->function('utf8_encode')
                        ->wasCalledWithIdenticalArguments((string) $obj)
                        ->once

                ->assert('with JsonSerializable object')
                    ->string(testedClass::encode($obj = new TestObjectJsonCompatible, testedClass::UTF8_ENCODE))
                        ->isIdenticalTo(json_encode($obj))
                    ->function('utf8_encode')
                        ->never
        ;
    }

    /**
     * @dataProvider encodeProvider
     */
    public function testEncodeToFile($json, $options)
    {
        $this
            ->if($this->function->file_put_contents = true)
            ->then
                ->boolean(testedClass::encodeToFile($json, $file = uniqid(), $options))
                    ->isTrue
                ->function('file_put_contents')
                    ->wasCalledWithIdenticalArguments($file, testedClass::encode($json, $options))
                    ->once
        ;
    }

    /** @php 5.4 */
    public function testDecode()
    {
        $this
            ->if($this->function->json_decode = $decoded = uniqid())
            ->and($defaultAssoc = false)
            ->and($defaultDepth = 512)
            ->and($defaultOptions = 0)
            ->then
                ->assert('no options')
                    ->string(testedClass::decode($json = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($json, $defaultAssoc, $defaultDepth, $defaultOptions)
                        ->once

                ->assert('force associative with argument')
                    ->string(testedClass::decode($json = uniqid(), $options = 0, $assoc = true))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithArguments($json, $assoc, $defaultDepth, $options)
                        ->once

                ->assert('force associative with options')
                    ->string(testedClass::decode($json = uniqid(), $options = testedClass::AS_ARRAY))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($json, true, $defaultDepth, 0)
                        ->once
        ;
    }

    /** @php < 5.4 */
    public function testDecode53()
    {
        $this
            ->if($this->function->json_decode = $decoded = uniqid())
            ->and($defaultAssoc = false)
            ->and($defaultDepth = 128)
            ->then
                ->assert('no options')
                    ->string(testedClass::decode($json = uniqid()))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($json, $defaultAssoc, $defaultDepth)
                        ->once

                ->assert('force associative with argument')
                    ->string(testedClass::decode($json = uniqid(), $options = 0, $assoc = true))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithArguments($json, $assoc, $defaultDepth)
                        ->once

                ->assert('force associative with options')
                    ->string(testedClass::decode($json = uniqid(), $options = testedClass::AS_ARRAY))
                        ->isIdenticalTo($decoded)
                    ->function('json_decode')
                        ->wasCalledWithIdenticalArguments($json, true, $defaultDepth)
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
            ->$type(testedClass::decodeToArray($value, $options))
                ->isIdenticalTo(testedClass::decode($value, $options | testedClass::AS_ARRAY))
        ;
    }

    /**
     * @dataProvider decodeProvider
     */
    public function testDecodeToObject($type, $value, $options)
    {
        $this
            ->$type(testedClass::decodeToObject($value, $options))
                ->isEqualTo(testedClass::decode($value, $options & ~testedClass::AS_ARRAY))
        ;
    }

    public function testDecodeFile()
    {
        $this
            ->given($this->function->is_file = true)
            ->and($this->function->file_get_contents = true)
            ->if(testedClass::decodeFile($file = uniqid()))
            ->then
                ->function('is_file')
                    ->wasCalled
                    ->once
                ->function('file_get_contents')
                    ->wasCalledWithIdenticalArguments($file)
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

    public function testEncodeNonUTF8()
    {
        $this
            ->exception(function () {
                testedClass::encode("\xB1\x31");
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
            array('test', 0),
            array(array(1, 2), 0),
            array(array('foo', 'bar'), 0),
            array('<test>', testedClass::HEX_TAG),
            array('&nbsp;', testedClass::HEX_AMP),
            array('"\'', testedClass::HEX_QUOT),
            array('"\'', testedClass::HEX_APOS),
            array('123', testedClass::NUMERIC_CHECK),
        );

        $php54 = array(
            array('1234567890', testedClass::BIGINT_AS_STRING),
            array(array(1, 2), testedClass::FORCE_OBJECT),
            array(' /!\\ ', testedClass::UNESCAPED_SLASHES),
            array('\u00e9', testedClass::UNESCAPED_UNICODE),
            array(array('foo', 'bar'), testedClass::PRETTY_PRINT),
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
