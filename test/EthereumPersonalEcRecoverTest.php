<?php

define('ETHEREUM_KECCAK_EXEC', '/opt/local/bin/keccak   --ethereum --string "#VALUE#"');

use Ethereum\Ethereum;
use Ethereum\EthD;
use Ethereum\EthD20;

/**
 * Testing keccak-256 hashing (web3.sha3()).
 */
class EthereumPersonalEcRecoverTest extends \PHPUnit_Framework_TestCase {

  /**
   * Testing keccak-256 hashing (web3.sha3()).
   */
  public function testEcrecoverBase() {

    // JSON-RPC web3_sha3() can not take an empty string as parameter.
    $message = 'I want to create a Account on this website. By I signing this text (using Ethereum personal_sign) I agree to the following conditions.';
    $signature = '0x627c13c55329e7eb3b377930e00b1186bf3115a9b4a45218eb8530caefbf125502edfaeb33a4c5f848b55ad5438c6e50160397bd47811f70df2173e536b4dd2c1b';
    $public_key = '0x4097752D39b5fB5C9b2490d53fB3d50f355DaD7A';

    $eth = new Ethereum('http://localhost:8545');
    $x = $eth->personalEcRecover($message, new EthD($signature), new EthD20($public_key));
    $this->assertTrue($x);

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
