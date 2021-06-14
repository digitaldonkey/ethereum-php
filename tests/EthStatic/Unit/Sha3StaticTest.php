<?php
namespace Ethereum;
use Ethereum\DataType\EthS;
use Ethereum\TestEthClient;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup staticTests
 */
class Sha3StaticTest extends TestStatic {

    public function kessacStringProvider() {
        // UTF8 text, Kessac256
        return [
          ['Hello world!', '0xecd0e108a98e192af1d2c25055f4e3bed784b5c877204e73219a5203251feaab'],
          ["\n", '0x0ef9d8f8804d174666011a394cab7901679a8944d24249fd148a6a36071151f8'],
          ['1', '0xc89efdaa54c0f20c7adf612882df0950f5a951637e0307cdcb4c672f298b8bc6'],
          ['-1', '0x798272c22de7de1bbb41d9d76b5240e67bb83e9ece1afeb940834536b3646693'],
          ['testing', '0x5f16f4c7f149ac4f9510d9cf8cf384038ad348b3bcdc01915f95de12df9d1b02'],
          ['', '0xc5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470'],
        ];
    }

  /**
   * @param $text
   * @param $sha3
   * @dataProvider kessacStringProvider
   *
   * @throws \Exception
   */
    public function testManyStrings($text, $sha3)
    {
        $this->assertSame($sha3, EthereumStatic::sha3($text));
    }

}
