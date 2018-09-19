<?php
namespace Ethereum;
use Ethereum\DataType\EthQ;
use Ethereum\TestStatic;
use Math_BigInteger;

/**
 * EthQTest
 *
 * @ingroup staticTests
 */
class EthQTest extends TestStatic
{
    /**
     * Testing quantities.
     *
     * This test is bases data by
     * http://www.binaryhexconverter.com/decimal-to-hex-converter.
     * @throw Exception
     */
    public function testEthQ__simple()
    {
        $x = new EthQ(999);
        $this->assertSame($x->val(), 999);
        $this->assertSame($x->hexVal(), '0x00000000000000000000000000000000000000000000000000000000000003e7');
        $this->assertSame($x->getSchemaType(), "Q");
    }

    /**
     * @throw Exception
     */
    public function testEthQ__zero()
    {

        $hex_null_short = new EthQ('0x');
        $this->assertSame($hex_null_short->val(), 0);
        $this->assertSame($hex_null_short->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');

        $hex_null = new EthQ('0x0');
        $this->assertSame($hex_null->val(), 0);
        $this->assertSame($hex_null->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');

        $int_null = new EthQ(0);
        $this->assertSame($int_null->val(), 0);
        $this->assertSame($int_null->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__one()
    {

        $hex_one = new EthQ('0x0000000000000000000000000000000000000000000000000000000000000001');
        $this->assertSame($hex_one->val(), 1);
        $this->assertSame($hex_one->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');

        $int_one = new EthQ(1);
        $this->assertSame($int_one->val(), 1);
        $this->assertSame($int_one->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');

    }

    /**
     * @throw Exception
     */
    public function testEthQ__random()
    {
        $hex_number = new EthQ('0x000003e7');
        $this->assertSame($hex_number->val(), 999);
        $this->assertSame($hex_number->hexVal(), '0x00000000000000000000000000000000000000000000000000000000000003e7');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__negative()
    {

      $x = new EthQ(-999);
      $this->assertSame($x->val(), -999);
      $this->assertSame($x->hexVal(), '0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffc19');

      // @deprecated Not supporting unpadded negative numbers anymore
      //  $y = new EthQ('0xfffffffffffffc19');
      //  $this->assertSame($y->val(), -999);
      //  $this->assertSame($y->hexVal(), '0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffc19');

      $z = new EthQ('0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffc19');
      $this->assertSame($z->hexVal(), '0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffc19');
      $this->assertSame($z->val(), -999);

      // You might still do the following for a unpadded negative hex number.
      $unpadded = new Math_BigInteger('0xfffffffffffffc19', -16);
      $y = new EthQ($unpadded->toString());
      $this->assertSame($y->val(), -999);
      $this->assertSame($y->hexVal(), '0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffc19');
    }

    // Given ABI.

    /**
     * @throw Exception
     */
    public function testEthQ__given_abi8()
    {
        $x = new EthQ('0x000000000000000000000000000000000000000000000000000000000000270f', ['abi' => 'uint16']);
        $this->assertSame($x->val(), 9999);
        $this->assertSame($x->hexVal(), '0x000000000000000000000000000000000000000000000000000000000000270f');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__abi16()
    {
        $x = new EthQ('0x0000270f', ['abi' => 'uint16']);
        $this->assertSame((int)$x->val(), 9999);
        $this->assertSame($x->hexVal(), '0x000000000000000000000000000000000000000000000000000000000000270f');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__abi8()
    {
        $x = new EthQ(255);
        $this->assertSame($x->val(), 255);
        $this->assertSame($x->hexVal(), '0x00000000000000000000000000000000000000000000000000000000000000ff');
        $this->assertSame($x->getAbi(), 'uint8');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__abi8_plus1()
    {
        $x = new EthQ(256);
        $this->assertSame($x->val(), 256);
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000100');
        $this->assertSame($x->getAbi(), 'uint16');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__abi8_neg()
    {
        $x = new EthQ(-255);
        $this->assertSame($x->val(), -255);
        $this->assertSame($x->hexVal(), '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff01');
        $this->assertSame($x->getAbi(), 'int8');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__abi8_neg_plus1()
    {
        $x = new EthQ(-256);
        $this->assertSame($x->val(), -256);
        $this->assertSame($x->hexVal(), '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff00');
        $this->assertSame($x->getAbi(), 'int16');
    }

    /**
     * @throw Exception
     */
    public function testEthQ__abi256()
    {
        $x = new EthQ('115792089237316000000000000000000000000000000000000000000000000000000000000000');
        $this->assertSame($x->val(), '115792089237316000000000000000000000000000000000000000000000000000000000000000');
        $this->assertSame($x->hexVal(), '0xffffffffffff86633a9e8f1256d61ed5325ebf2a4b4366ba0000000000000000');
    }

    // Made TO FAIL
    public function testEthQ__given_abi8_should_be_wrong()
    {
        $this->expectException(\InvalidArgumentException::class);
        new EthQ(9999, ['abi' => 'uint8']);
    }

    public function testEthQ__abi256_plus1()
    {
        $this->expectException(\InvalidArgumentException::class);
        new EthQ('115792089237316000000000000000000000000000000000000000000000000000000000000000115792089237316000000000000000000000000000000000000000000000000000000000000000');
    }
}


/*

NUMBER MAGIC CSV

EXPONENT;2^EXPONENT;2^Exponent -1
8;256;255
16;65536;65535
24;16777216;16777215
32;4294967296;4294967295
40;1099511627776;1099511627775
48;281474976710656;281474976710655
56;72057594037927900;72057594037927900
64;18446744073709600000;18446744073709600000
72;4722366482869650000000;4722366482869650000000
80;1208925819614630000000000;1208925819614630000000000
88;309485009821345000000000000;309485009821345000000000000
96;79228162514264300000000000000;79228162514264300000000000000
104;20282409603651700000000000000000;20282409603651700000000000000000
112;5192296858534830000000000000000000;5192296858534830000000000000000000
120;1329227995784920000000000000000000000;1329227995784920000000000000000000000
128;340282366920938000000000000000000000000;340282366920938000000000000000000000000
136;87112285931760200000000000000000000000000;87112285931760200000000000000000000000000
144;22300745198530600000000000000000000000000000;22300745198530600000000000000000000000000000
152;5708990770823840000000000000000000000000000000;5708990770823840000000000000000000000000000000
160;1461501637330900000000000000000000000000000000000;1461501637330900000000000000000000000000000000000
168;374144419156711000000000000000000000000000000000000;374144419156711000000000000000000000000000000000000
176;95780971304118100000000000000000000000000000000000000;95780971304118100000000000000000000000000000000000000
184;24519928653854200000000000000000000000000000000000000000;24519928653854200000000000000000000000000000000000000000
192;6277101735386680000000000000000000000000000000000000000000;6277101735386680000000000000000000000000000000000000000000
200;1606938044258990000000000000000000000000000000000000000000000;1606938044258990000000000000000000000000000000000000000000000
208;411376139330302000000000000000000000000000000000000000000000000;411376139330302000000000000000000000000000000000000000000000000
216;105312291668557000000000000000000000000000000000000000000000000000;105312291668557000000000000000000000000000000000000000000000000000
224;26959946667150600000000000000000000000000000000000000000000000000000;26959946667150600000000000000000000000000000000000000000000000000000
232;6901746346790560000000000000000000000000000000000000000000000000000000;6901746346790560000000000000000000000000000000000000000000000000000000
240;1766847064778380000000000000000000000000000000000000000000000000000000000;1766847064778380000000000000000000000000000000000000000000000000000000000
248;452312848583266000000000000000000000000000000000000000000000000000000000000;452312848583266000000000000000000000000000000000000000000000000000000000000
256;115792089237316000000000000000000000000000000000000000000000000000000000000000;115792089237316000000000000000000000000000000000000000000000000000000000000000
*/
