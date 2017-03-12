<?php


use Ethereum\EthD;

/**
 *
 */
class EthereumStaticTestEthD extends \PHPUnit_Framework_TestCase {

  /**
   * Testing quantities.
   */
  public function testEthD__simple() {

    $x = new EthD('0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
    $this->assertSame($x->val(), '4f1116b6e1a6e963efffa30c0a8541075cc51c45');
    $this->assertSame($x->hexVal(), '0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');

    $this->assertSame($x->getType($schema = FALSE), "EthD");
    $this->assertSame($x->getType($schema = TRUE), "D");
  }

  // Made to Fail.
  public function testEthQ__notHexPrefixed() {
    $this->setExpectedException(Exception::class);
    new EthD('4f1116b6e1a6e963efffa30c0a8541075cc51c45');
  }

  public function testEthQ__notHex() {
    try {
      $val = '0xyz116b6e1a6e963efffa30c0a8541075cc51c45';
      $exception_message_expected = 'A non well formed hex value encountered: ' . $val;
      new EthD($val);
      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
    }
    catch (\Exception $exception) {
      $this->assertEquals($exception->getMessage(), $exception_message_expected);
    }
  }

}
