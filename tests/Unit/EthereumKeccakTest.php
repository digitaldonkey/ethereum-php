<?php

define('ETHEREUM_KECCAK_EXEC', '/opt/local/bin/keccak   --ethereum --string "#VALUE#"');

use Ethereum\Ethereum;

/**
 * Testing keccak-256 hashing (web3.sha3()).
 */
class EthereumKeccakTest extends \PHPUnit_Framework_TestCase {

  /**
   * Testing keccak-256 hashing (web3.sha3()).
   */
  public function testKeccakBase() {

    // JSON-RPC web3_sha3() can not take an empty string as parameter.
    if (defined('ETHEREUM_KECCAK_EXEC')) {
      $eth = new Ethereum('http://localhost:8545');
      $x = $eth->keccak256('');
      $this->assertEquals($x, "0xc5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470");
    }
    else {
      $this->markTestSkipped(
        'Skipping test. keccak256("") is not possible supported when ETHEREUM_KECCAK_EXEC is not defined. .'
      );
    }

  }

  /**
   * Testing keccak-256 hashing (web3.sha3()).
   */
  public function testKeccakFromWiki() {
    $eth = new Ethereum('http://localhost:8545');
    $x = $eth->keccak256('hello world');
    $this->assertEquals($x, "0x47173285a8d7341e5e972fc677286384f802f8ef42a5ec5f03bbfa254cb01fad");
  }

}
