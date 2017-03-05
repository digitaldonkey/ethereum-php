<?php


use Ethereum\EthQ;

/**
 *
 */
class EthereumStaticTestEthQ extends \PHPUnit_Framework_TestCase {

  /**
   * Testing quantities.
   *
   * This test is bases data by
   * http://www.binaryhexconverter.com/decimal-to-hex-converter.
   */
  public function testEthQSimple() {
    $x = new EthQ(999);
    $this->assertSame($x->val(), 999);
    $this->assertSame($x->hexVal(), '0x000003e7');
    $this->assertSame($x->getType($schema = FALSE), "EthQ");
    $this->assertSame($x->getType($schema = TRUE), "Q");
  }

  public function testEthQZero() {

    $hex_null_short = new EthQ('0x');
    $this->assertSame($hex_null_short->val(), 0);
    $this->assertSame($hex_null_short->hexVal(), '0x00000000');

    $hex_null = new EthQ('0x0');
    $this->assertSame($hex_null->val(), 0);
    $this->assertSame($hex_null->hexVal(), '0x00000000');

    $int_null = new EthQ(0);
    $this->assertSame($int_null->val(), 0);
    $this->assertSame($int_null->hexVal(), '0x00000000');
  }

  public function testEthQOne() {

    $hex_one = new EthQ('0x00000001');
    $this->assertSame($hex_one->val(), 1);
    $this->assertSame($hex_one->hexVal(), '0x00000001');

    $int_one = new EthQ(1);
    $this->assertSame($int_one->val(), 1);
    $this->assertSame($int_one->hexVal(), '0x00000001');

  }

  public function testEthQRandom() {
    $hex_number = new EthQ('0x000003e7');
    $this->assertSame($hex_number->val(), 999);
    $this->assertSame($hex_number->hexVal(), '0x000003e7');
  }

  public function testEthNegative() {

    $x = new EthQ(-999);
    $this->assertSame($x->val(), -999);
    $this->assertSame($x->hexVal(), '0xfffffc19');

    $y = new EthQ('0xfffffffffffffc19');
    $this->assertSame($y->val(), -999);
    $this->assertSame($y->hexVal(), '0xfffffffffffffc19');

      $z = new EthQ('0xfffffc19');
      $this->assertSame($z->hexVal(), '0xfffffc19');
      $this->assertSame($z->val(), -999);
  }

  // Given ABI.
  public function testEthQAbi8() {
    $x = new EthQ('0x0000270f', array('abi' => 'uint8'));
    $this->assertSame($x->val(), 9999);
    $this->assertSame($x->hexVal(), '0x0000270f');
  }

  public function testEthQAbi16() {

    $typed_hex_number_16 = new EthQ('0x0000270f', array('abi' => 'uint16'));
    $this->assertSame((int) $typed_hex_number_16->val(), 9999);
    $this->assertSame($typed_hex_number_16->hexVal(), '0x000000000000270f');
  }

  public function testEthQAbi256() {
    $typed_hex_number_16 = new EthQ('0x0000270f', array('abi' => 'int256'));
    $this->assertSame((int) $typed_hex_number_16->val(), 9999);
    $this->assertSame($typed_hex_number_16->hexVal(), '0x000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000270f');
  }

  // Made to Fail.
  public function testEthQWrongLength() {
    $this->setExpectedException(InvalidArgumentException::class);
    new EthQ('0xfffffc1');
  }

  public function testEthQTooLong() {
    $this->setExpectedException(InvalidArgumentException::class);
    new EthQ('0x' . str_repeat('0', 2 ^ 256) . '1');
  }

}
