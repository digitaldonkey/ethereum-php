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
class EcRecoverTest extends TestEthClient {


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
            '',
          ],
//          [
//            '0x9b2055d370f73ec7d8a03e965129118dc8f5bf83',
//            '0xdeadbeaf', // 0xdeadbeaf is not a valid UTF8 String.
//            '0xa3f20717a250c2b0b729b7e5becbff67fdaef7e0699da4de7ca5895b02a170a12d887fd3b17bfdce3481f10bea41f45ba9f709d39ce8325427b57afcfc994cee1b',
//            '0xdeadbeaf'
//          ],
//          [
//            '0xf17f52151ebef6c7334fad080c5704d77216b732', // OK
//            'Welcome back!\r\nPlease sign to log-in today (Tue, 04\/24\/2018 - 12:58).\r\n',
//            '0xc5926706663602a458959c6405a7144ea75961c1e01b786fda57cfd3e62d40ef5da6970cf1e4fdd96e5d743d213939f2b4ac86976d49a4e22133f0a85eb3e46b1c',
//            '0x57656c636f6d65206261636b210d0a506c65617365207369676e20746f206c6f672d696e20746f64617920285475652c2030342f32342f32303138202d2031323a3538292e0d0a'
//          ],
//          [
//            '0xbe93f9bacbcffc8ee6663f2647917ed7a20a57bb',
//            'Hi, Alice!',
//            '0xb2c9c7bdaee2cc73f318647c3f6e24792fca86a9f2736d9e7537e64c503545392313ebbbcb623c828fd8f99fd1fb48f8f4da8cb1d1a924e28b21de018c826e181c',
//            '0x48692c20416c69636521',
//          ],
//          [
//          // https://github.com/MetaMask/provider-engine/blob/006a94d4ad5c2a8a147d2a440495d0c3defab498/test/wallet.js#L202-L210
//          // THIS TEST SEEMS WRONG IN METAMASK
//            '0xbe93f9bacbcffc8ee6663f2647917ed7a20a57bb',
//            'Áu¹Àñ¶¨1Ãâiw&aë_þæ®/ì:×wu1W',
//            '0xce909e8ea6851bc36c007a0072d0524b07a3ff8d4e623aca4c71ca8e57250c4d0a3fc38fa8fbaaa81ead4b9f6bd03356b6f8bf18bccad167d78891636e1d69561b',
//            '0xc38175c2b9c380c3b1c2b6c2a831c383c299c3a269772661c292c3ab5fc3bec3a6c2ae2fc3ac3ac3971c77753157',
//          ],
//          [
//            // https://github.com/MetaMask/provider-engine/blob/006a94d4ad5c2a8a147d2a440495d0c3defab498/test/wallet.js#L212-L220
//            '0xbe93f9bacbcffc8ee6663f2647917ed7a20a57bb',
//            'hello world',
//            '0x9ff8350cc7354b80740a3580d0e0fd4f1f02062040bc06b893d70906f8728bb5163837fd376bf77ce03b55e9bd092b32af60e86abce48f7b8d3539988ee5a9be1c',
//          ],
//          [
//            '0xbe93f9bacbcffc8ee6663f2647917ed7a20a57bb',
//            'hello world',
//            '0xce909e8ea6851bc36c007a0072d0524b07a3ff8d4e623aca4c71ca8e57250c4d0a3fc38fa8fbaaa81ead4b9f6bd03356b6f8bf18bccad167d78891636e1d69561b'
//          ],
//          [
//            '0xf17f52151EbEF6C7334FAD080c5704D77216b732',
//            'Welcome back!\r\nPlease sign to log-in today (Mon, 04/23/2018 - 18:36).\r\n',
//            '0x54d46d72c9a3ac6d81fff8a2ab052c1c2f5d6e2997fc56400916e1498171d11812c1e21720f1bbb7ee2f1589dd59b036d5a8dff191dcb88317a1316f646140ab1c',
//          ],
//          [
//            '0x7156526fbd7a3c72969b54f64e42c10fbb768c8a',
//            'hello',
//            '0x9242685bf161793cc25603c231bc2f568eb630ea16aa137d2664ac80388256084f8ae3bd7535248d0bd448298cc2e2071e56992d0774dc340c368ae950852ada1c',
//          ],
//          [
//            '0x12890d2cce102216644c59dae5baed380d84830c',
//            'test',
//            '0x0976a177078198a261faf206287b8bb93ebb233347ab09a57c8691733f5772f67f398084b30fc6379ffee2cc72d510fd0f8a7ac2ee0162b95dc5d61146b40ffa1c'
//          ],
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
      $web3 = new Ethereum(SERVER_URL);
      $message_hash = $web3->sha3(EcRecover::personalSignAddHeader($message));
      $this->assertSame($address, EcRecover::phpEcRecover(new EthD32($message_hash), new EthD($signature)));
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
  public function testPersonalEcRecover($address, $message, $signature, $messageHex)
  {
    $this->assertSame($address, EcRecover::personalEcRecover($message, $signature));
  }
}
