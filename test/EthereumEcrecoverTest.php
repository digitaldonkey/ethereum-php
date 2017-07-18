<?php

use Ethereum\Ethereum;
use Ethereum\EthD32;
use Ethereum\EthQ;
use Ethereum\EthD20;

/**
 * Testing keccak-256 hashing (web3.sha3()).
 */
class EthereumEcrecoverTest extends \PHPUnit_Framework_TestCase {

  /**
   * Testing keccak-256 hashing (web3.sha3()).
   */
  public function testEcrecoverBase() {

    $expect = '0x4097752d39b5fb5c9b2490d53fb3d50f355dad7a';

    $message = new EthD32('0xdc0e5f8d3edf066da77f7a5664ca95fc75854567901aca68abb36987a46021b7');
    $v = new EthQ('0x1b');
    $r = new EthD32('0x627c13c55329e7eb3b377930e00b1186bf3115a9b4a45218eb8530caefbf1255');
    $s = new EthD32('0x02edfaeb33a4c5f848b55ad5438c6e50160397bd47811f70df2173e536b4dd2c');

    $eth = new Ethereum('http://localhost:8545');
    $x = $eth->phpEcRecover($message, $v, $r, $s);
    $this->assertEquals($x, $expect);
  }

}
