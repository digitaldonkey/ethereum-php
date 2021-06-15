<?php
namespace Ethereum;

use Ethereum\RLP\Rlp;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup staticTests
 */
class RlpTest extends TestStatic {


  /**
   * What a testMess....
   *
   * Metamask: Most tests don't work.
   * https://github.com/MetaMask/provider-engine/blob/master/test/wallet.js
   *
   * Nethereum
   * https://github.com/Nethereum/Nethereum/blob/master/src/Nethereum.Signer.UnitTests/EthereumMessageSignerTests.cs
   *
   * @return array
   */
    public function rlpDataProvider() {
      return [
          // Array (AbiType, RLP value , RLP type, value)

          // @todo MORE TESTS. See also MultiReturnerTest.php

          [
            'bytes',
            '00000000000000000000000000000000000000000000000000000000000000036162630000000000000000000000000000000000000000000000000000000000',
            'PREF_SHORT_ITEM',
            '616263'
          ],
          [
            'bytes',
            '000000000000000000000000000000000000000000000000000000000000003c61626361626361626363616263616263616263636162636162636162636361626361626361626363616263616263616263636162636162636162636300000000',
            'PREF_LONG_ITEM', // 0x20 should be short, but it's > 55bytes ???
            '616263616263616263636162636162636162636361626361626361626363616263616263616263636162636162636162636361626361626361626363'
          ],
        ];
    }


  /**
   * @dataProvider rlpDataProvider
   *
   * @param $address
   * @param $message
   * @param $signature
   * @param $messageHex
   */
  public function testUtf8ToMessage($abiType, $rlpValue, $rlpType, $value)
  {
    $test = Rlp::decode($rlpValue);
    $AAA = $test[0]->get();
    $this->assertSame($AAA, $value);
  }

}
