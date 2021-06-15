<?php
namespace Ethereum;

use Ethereum\DataType\EthD32;
use Ethereum\DataType\EthD;
use Ethereum\DataType\EthS;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup staticTests
 */
class EcRecoverStaticTest extends TestStatic {


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
    public function ecRecoverDataProvider() {
        /* Note:
         * You can evaluate in browser using web3js:
         *
         * web3.personal.ecRecover(
         *  "I want to create a Account on this website. By I signing this text (using Ethereum personal_sign) I agree to the following conditions.",
         *  "0xbbdcdfb9fbe24d460a683633475c77a44072b527a127b159ffaaa043f5dc944105a1671c8b9df95e377d89ec17a1a0ed13f5caa33e5fa80bdf12391bf2e04e4f1c",
         *  (e,f)=>{console.log(e,f)}
         * )
         *
         */
      return [
          // Array (Address, Message (UTF8), Signature, Message (Hex string))
          [
            '0xbe93f9bacbcffc8ee6663f2647917ed7a20a57bb',
            'hello world',
            '0xce909e8ea6851bc36c007a0072d0524b07a3ff8d4e623aca4c71ca8e57250c4d0a3fc38fa8fbaaa81ead4b9f6bd03356b6f8bf18bccad167d78891636e1d69561b',
            '0x68656c6c6f20776f726c64'
          ],
          [
            // Nethereum https://github.com/Nethereum/Nethereum/blob/6b4544ec8838cfb72ac3aed2f54ad6f62aafae78/src/Nethereum.Signer.UnitTests/EthereumMessageSignerTests.cs#L73-L82
            '0xe651c5051ce42241765bbb24655a791ff0ec8d13',
            'wee test message 18/09/2017 02:55PM',
            '0xf5ac62a395216a84bd595069f1bb79f1ee08a15f07bb9d9349b3b185e69b20c60061dbe5cdbe7b4ed8d8fea707972f03c21dda80d99efde3d96b42c91b2703211b',
            '0x7765652074657374206d6573736167652031382f30392f323031372030323a3535504d',
          ],
          [
            '0x9283099a29556fcf8fff5b2cea2d4f67cb7a7a8b',
            'I am but a stack exchange post',
            '0x0cf7e2e1cbaf249175b8e004118a182eb378a0b78a7a741e72a0a34e970b59194aa4d9419352d181a4d1827abbad279ad4f5a7b60da5751b82fec4dde6f380a51b',
            '0x4920616d20627574206120737461636b2065786368616e676520706f7374',
          ],
          [
            '0xb61f34dc82977e2b8c2bd747284b47ab94615bff',
            'I want to create a Account on this website. By I signing this text (using Ethereum personal_sign) I agree to the following conditions.',
            '0xbbdcdfb9fbe24d460a683633475c77a44072b527a127b159ffaaa043f5dc944105a1671c8b9df95e377d89ec17a1a0ed13f5caa33e5fa80bdf12391bf2e04e4f1c',
            '0x492077616e7420746f206372656174652061204163636f756e74206f6e207468697320776562736974652e2042792049207369676e696e672074686973207465787420287573696e6720457468657265756d20706572736f6e616c5f7369676e29204920616772656520746f2074686520666f6c6c6f77696e6720636f6e646974696f6e732e',
          ],
        ];
    }


  /**
   * @dataProvider ecRecoverDataProvider
   *
   * @param $address
   * @param $message
   * @param $signature
   * @param $messageHex
   */
  public function testUtf8ToMessage($address, $message, $signature, $messageHex)
  {
    $test = EthereumStatic::ensureHexPrefix(EthS::strToHex($message));
    $this->assertSame($messageHex, $test);
  }


  /**
   * @dataProvider ecRecoverDataProvider
   *
   * @param $address
   * @param $message
   * @param $signature
   * @param $messageHex
   *
   * @throws \Exception
   */
    public function testRestoreAddress($address, $message, $signature, $messageHex)
    {
      $recoveredAddr = Ethereum::personalEcRecover($message, new EthD($signature) );
      $this->assertSame($address, $recoveredAddr);
    }

}
