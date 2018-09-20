<?php
namespace Ethereum;

use Ethereum\DataType\EthD32;

/**
 * Fixing unpadded quantities can cause negative valu interpretation.
 *
 * @see https://github.com/digitaldonkey/ethereum-php/issues/38
 *
 * @ingroup ethereumTests
 */
class FixUnpaddedValuesTest extends TestEthClient
{

    public function testMainNetTx() {
      $web3 = new Ethereum('https://mainnet.infura.io/drupal');

      // @see https://etherscan.io/tx/0x527e9b670536c09fe160b0c2e33728eadd7f8affae7803049fa8d8ec2d1c7cfe
      $mainNetTx = new EthD32('0x527e9b670536c09fe160b0c2e33728eadd7f8affae7803049fa8d8ec2d1c7cfe');
      $transaction = $web3->eth_getTransactionByHash($mainNetTx);

      $this->assertSame(1.12208103, EthereumStatic::convertCurrency($transaction->value->val()));
    }

}


