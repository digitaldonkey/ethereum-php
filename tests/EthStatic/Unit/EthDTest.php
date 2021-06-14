<?php
namespace Ethereum;
use Ethereum\DataType\EthD;
use Ethereum\TestStatic;
use ReflectionClass;

/**
 * EthDTest
 *
 * @ingroup staticTests
 */
class EthDTest extends TestStatic
{
    /**
     * Testing quantities.
     * @throw Exception
     */
    public function testEthD__simple()
    {

        $x = new EthD('0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertSame($x->val(), '4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertSame($x->hexVal(), '0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertSame($x->getSchemaType(), "D");
    }

    // Made to Fail.
    public function testEthD__notHexPrefixed()
    {
        $a = new EthD('4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertEquals($a->hexVal(), '0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
    }

    public function testEthQD__notHex()
    {
        try {
            $val = '0xyz116b6e1a6e963efffa30c0a8541075cc51c45';
            $exception_message_expected = 'A non well formed hex value encountered: ' . $val;
            new EthD($val);
            $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }



    public function convertDataProvider()
    {
        return [
          // [ABI, value, Expected type class, expected value]
          [
            'bool',
            '0x0000000000000000000000000000000000000000000000000000000000000001',
            'EthB',
            true
          ],
          [
            'bool',
            '0x0000000000000000000000000000000000000000000000000000000000000000',
            'EthB',
            false
          ],
          [
            'uint256',
            '0x000000000000000000000000000000000000000000000000000000000000000e',
            'EthQ',
            14
          ],
          [
            'uint', // Should fall back to uint256
            '0x000000000000000000000000000000000000000000000000000000000000000e',
            'EthQ',
            14
          ],
          [
            'int256',
            '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
            'EthQ',
            -1
          ],
          [
            'int', // Should fall back to int256
            '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff',
            'EthQ',
            -1
          ],
          [
            'uint32',
            '0x000000000000000000000000000000000000000000000000000000000000002a',
            'EthQ',
            42
          ],
          [
            'int256',
            '0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffc19',
            'EthQ',
            -999
          ],
          [
            'address',
            '0xf17f52151EbEF6C7334FAD080c5704D77216b732',
            'EthD20',
            'f17f52151ebef6c7334fad080c5704d77216b732'
          ],

            // TOOO LONG FOR NOW Requires RLP.
            // ['string', '0x0000000000000000000000000000000000000000000000000000000000000020000000000000000000000000000000000000000000000000000000000000001f6120726573706f6e736520737472696e672028756e737570706f727465642900', 'EthQ', 'a response string (unsupported)'],
        ];
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthD__converter($abi, $value, $expClass, $expVal)
    {
        $x = new EthD($value);
        $y = $x->convertByAbi($abi);
        $className = (new ReflectionClass($y))->getShortName();
        $this->assertEquals($expClass, $className);
        $this->assertEquals($expVal, $y->val());
    }
}
