<?php
namespace Ethereum;

use Ethereum\DataType\EthD20;


/**
 * EthD20Test
 *
 * @ingroup staticTests
 */
class EthD20Test extends TestStatic
{
    /**
     * Testing quantities.
     * @throw Exception
     */
    public function testEthD20__simple()
    {

        $x = new EthD20('0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');
        $this->assertSame($x->val(), '3facfa472e86e3edaeaa837f6ba038ac01f7f539');
        $this->assertSame($x->hexVal(), '0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');
        $this->assertSame($x->getSchemaType(), "D20");
    }

    // Made to Fail.
    public function testEthQ__invalidLengthTooLong()
    {
        try {
            new EthD20('0x3facfa472e86e3edaeaa837f6ba038ac01f7f53989');
            $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
        } catch (\Exception $exception) {
            $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== false);
        }
    }

    public function testEthQ__invalidLengthShort()
    {

        try {
            new EthD20('0x0');
            $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
        } catch (\Exception $exception) {
            $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== false);
        }
    }

    public function testEthQ__notHexPrefixed()
    {
        // Change note: Now you can use unprefixed values again.
        $a = new EthD20('4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertEquals($a->hexVal(), '0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
    }

    public function testEthQ__notHex()
    {
        try {
            $val = '0xyz116b6e1a6e963efffa30c0a8541075cc51c45';
            $exception_message_expected = 'A non well formed hex value encountered: ' . $val;
            new EthD20($val);
            $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }
}
