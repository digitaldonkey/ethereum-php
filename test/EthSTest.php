<?php


use Ethereum\EthS;

/**
 *
 */
class EthereumStaticTestEthS extends \PHPUnit_Framework_TestCase {

  /**
   * This test is bases data by http://codebeautify.org/hex-string-converter.
   */
  public function testEthS() {

    $str = new EthS('Hello World');
    $this->assertEquals($str->val(), "Hello World");

    $this->assertEquals($str->getType($schema = FALSE), "EthS");
    $this->assertEquals($str->getType($schema = TRUE), "S");

    $hex_str = new EthS('0x48656c6c6f20576f726c64');
    $this->assertEquals($hex_str->val(), "Hello World");

    $str_hex = new EthS("Hello World");
    $this->assertEquals($hex_str->hexVal(), '0x48656c6c6f20576f726c64');
  }

}
