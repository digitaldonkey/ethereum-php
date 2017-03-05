<?php


use Ethereum\EthS;

/**
 *
 */
class EthereumStaticTestEthS extends \PHPUnit_Framework_TestCase {

  /**
   * This test is bases data by http://codebeautify.org/hex-string-converter.
   */
  public function testEthS__types() {

    $x = new EthS('Hello World');
    $this->assertEquals($x->val(), "Hello World");

    $this->assertEquals($x->getType($schema = FALSE), "EthS");
    $this->assertEquals($x->getType($schema = TRUE), "S");
  }

  public function testEthS__hexToString() {

    $x = new EthS('0x48656c6c6f20576f726c64');
    $this->assertEquals($x->val(), "Hello World");
  }

  public function testEthS__stringToHex() {

    $x = new EthS("Hello World");
    $this->assertEquals($x->hexVal(), '0x48656c6c6f20576f726c64');
  }

}
