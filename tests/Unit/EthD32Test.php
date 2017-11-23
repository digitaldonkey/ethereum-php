<?php


use Ethereum\EthD32;

/**
 *
 */
class EthereumStaticTestEthD32 extends \PHPUnit_Framework_TestCase {

  /**
   * Testing quantities.
   */
  public function testEthD32__simple() {

    $x = new EthD32('0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
    $this->assertSame($x->val(), 'f79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
    $this->assertSame($x->hexVal(), '0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');

    $this->assertSame($x->getType($schema = FALSE), "EthD32");
    $this->assertSame($x->getType($schema = TRUE), "D32");
  }

  // Made to Fail.
  public function testEthQ__invalidLengthTooLong() {
    try {
      new EthD32('0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd86');
      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
    }
    catch (\Exception $exception) {
      $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== FALSE);
    }
  }

  public function testEthQ__invalidLengthShort() {

    try {
      new EthD32('0x0');
      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
    }
    catch (\Exception $exception) {
      $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== FALSE);
    }
  }

  public function testEthQ__notHexPrefixed() {
    $this->setExpectedException(Exception::class);
    new EthD32('f79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd');
  }

  public function testEthQ__notHex() {
    try {
      $val = '0xyz116b6e1a6e963efffa30c0a8541075cc51c45';
      $exception_message_expected = 'A non well formed hex value encountered: ' . $val;
      new EthD32($val);
      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
    }
    catch (\Exception $exception) {
      $this->assertEquals($exception->getMessage(), $exception_message_expected);
    }
  }

}
