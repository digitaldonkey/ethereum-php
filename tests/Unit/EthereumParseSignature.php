<?php

use Ethereum\Ethereum;
use Ethereum\EthD;
use Ethereum\EthD32;
use Ethereum\EthQ;


/**
 * Testing keccak-256 hashing (web3.sha3()).
 */
class EthereumParseSignature extends \PHPUnit_Framework_TestCase {

  /**
   * Testing keccak-256 hashing (web3.sha3()).
   */
  public function testParseSignatureOne() {
    $signature = new EthD('0x627c13c55329e7eb3b377930e00b1186bf3115a9b4a45218eb8530caefbf125502edfaeb33a4c5f848b55ad5438c6e50160397bd47811f70df2173e536b4dd2c1b');
    $expect = array(
      'r' => new EthD32('0x627c13c55329e7eb3b377930e00b1186bf3115a9b4a45218eb8530caefbf1255'),
      's' => new EthD32('0x02edfaeb33a4c5f848b55ad5438c6e50160397bd47811f70df2173e536b4dd2c'),
      'v' => new EthQ(27),
    );
    $x = Ethereum::parseSignature($signature);
    $this->assertEquals($x, $expect);
  }

//  /**
//   * Testing keccak-256 hashing (web3.sha3()).
//   */
//  public function testKeccakFromWiki() {
//    $eth = new Ethereum('http://localhost:8545');
//    $x = $eth->keccak256('hello world');
//    $this->assertEquals($x, "0x47173285a8d7341e5e972fc677286384f802f8ef42a5ec5f03bbfa254cb01fad");
//  }

}
