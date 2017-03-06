<?php


use Ethereum\EthBlockParam;

/**
 *
 */
class EthereumStaticTestEthBlockParam extends \PHPUnit_Framework_TestCase {

  /**
   * Testing quantities.
   */
  public function testEthBlockParam__address() {

    $x = new EthBlockParam('0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');
    $this->assertSame($x->val(), '3facfa472e86e3edaeaa837f6ba038ac01f7f539');
    $this->assertSame($x->hexVal(), '0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');

    $this->assertSame($x->getType($schema = FALSE), "EthBlockParam");
    $this->assertSame($x->getType($schema = TRUE), "Q|T");
  }

  public function testEthBlockParam__tagLatest() {

    $x = new EthBlockParam('latest');
    $this->assertSame($x->val(), 'latest');
    $this->assertSame($x->hexVal(), 'latest');
  }

  public function testEthBlockParam__tagPending() {

    $x = new EthBlockParam('pending');
    $this->assertSame($x->val(), 'pending');
    $this->assertSame($x->hexVal(), 'pending');
  }

  public function testEthBlockParam__tagErliest() {

    $x = new EthBlockParam('earliest');
    $this->assertSame($x->val(), 'earliest');
    $this->assertSame($x->hexVal(), 'earliest');
  }

  // Made to Fail.
//  public function testEthQ__invalidLengthTooLong() {
//    try {
//      new EthBlockParam('0x3facfa472e86e3edaeaa837f6ba038ac01f7f53989');
//      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
//    }
//    catch (\Exception $exception) {
//      $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== FALSE);
//    }
//  }
//
//  public function testEthQ__invalidLengthShort() {
//
//    try {
//      new EthBlockParam('0x0');
//      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
//    }
//    catch (\Exception $exception) {
//      $this->assertTrue(strpos($exception->getMessage(), "Invalid length") !== FALSE);
//    }
//  }
//
//  public function testEthQ__notHexPrefixed() {
//    $this->setExpectedException(Exception::class);
//    new EthBlockParam('4f1116b6e1a6e963efffa30c0a8541075cc51c45');
//  }
//
//  public function testEthQ__notHex() {
//    try {
//      $exception_message_expected = 'A non well formed numeric value encountered';
//      new EthBlockParam('0xyz116b6e1a6e963efffa30c0a8541075cc51c45');
//      $this->fail("Expected exception '" . $exception_message_expected . "' not thrown");
//    }
//    catch (\Exception $exception) {
//      $this->assertEquals($exception->getMessage(), $exception_message_expected);
//    }
//  }

}
