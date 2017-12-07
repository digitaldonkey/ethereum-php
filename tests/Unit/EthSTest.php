<?php
namespace Ethereum;
use Ethereum\EthS;
use Ethereum\EthTest;

/**
 * EthQTest
 *
 * @ingroup tests
 */
class EthSTest extends EthTest
{
    /**
     * This test is bases data by http://codebeautify.org/hex-string-converter.
     * @throw Exception
     */
    public function testEthS__types()
    {

        $x = new EthS('Hello World');
        $this->assertEquals($x->val(), "Hello World");

        $this->assertEquals($x->getType($schema = false), "EthS");
        $this->assertEquals($x->getType($schema = true), "S");
    }

    public function testEthS__hexToString()
    {

        $x = new EthS('0x48656c6c6f20576f726c64');
        $this->assertEquals($x->val(), "Hello World");
    }

    public function testEthS__stringToHex()
    {

        $x = new EthS("Hello World");
        $this->assertEquals($x->hexVal(), '0x48656c6c6f20576f726c64');
    }
}
