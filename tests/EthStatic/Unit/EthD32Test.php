<?php
namespace Ethereum;
use Ethereum\DataType\EthD32;

/**
 * EthD32Test
 *
 * @ingroup staticTests
 */
class EthD32Test extends TestStatic
{
    /**
     * Testing quantities.
     * @throw Exception
     */
    public function testEthD32__simple()
    {

        $x = new EthD32('0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
        $this->assertSame($x->val(), 'f79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
        $this->assertSame($x->hexVal(), '0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
        $this->assertSame($x->getSchemaType(), "D32");
    }

    // Made to Fail.
    public function testEthQ__invalidLengthTooLong()
    {
        try {
            new EthD32('0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd86');
            $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
        } catch (\Exception $exception) {
            $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== false);
        }
    }

    public function testEthQ__notHexPrefixed()
    {
        $a = new EthD32('f79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
        $this->assertEquals($a->hexVal(), '0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
    }

    public function testEthQ__notHex()
    {
        try {
            $val = '0xyz116b6e1a6e963efffa30c0a8541075cc51c45';
            $exception_message_expected = 'A non well formed hex value encountered: ' . $val;
            new EthD32($val);
            $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }
}
