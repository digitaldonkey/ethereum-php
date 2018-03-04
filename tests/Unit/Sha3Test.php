<?php
namespace Ethereum;
use Ethereum\EthS;
use Ethereum\EthTest;
use kornrunner\Keccak;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup tests
 */
class Sha3Test extends EthTest {

    private $eth;

    private $testStrings;

    public function __construct()
    {
        $this->eth = new Ethereum('http://localhost:7545');
        $this->testStrings = [
            'Hello world!' => '0xecd0e108a98e192af1d2c25055f4e3bed784b5c877204e73219a5203251feaab',
            "\n" => '0x0ef9d8f8804d174666011a394cab7901679a8944d24249fd148a6a36071151f8',
            '1' => '0xc89efdaa54c0f20c7adf612882df0950f5a951637e0307cdcb4c672f298b8bc6',
            '-1' => '0x798272c22de7de1bbb41d9d76b5240e67bb83e9ece1afeb940834536b3646693',
            'testing' => '0x5f16f4c7f149ac4f9510d9cf8cf384038ad348b3bcdc01915f95de12df9d1b02'
        ];
    }

    public function testEmptyString()
    {
        // $x = $this->eth->web3_sha3(new EthS(''));
        $x = EthereumStatic::sha3('');
        $this->assertSame('0xc5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470', $x);
    }

    public function testEmptyStringWithEthereumSha3()
    {
        $x = $this->eth->web3_sha3(new EthS(''));
        $this->assertSame(
          '0xc5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470',
          $x->hexVal()
        );
    }


    public function testManyStrings()
    {
        foreach ($this->testStrings as $k => $sha3) {
            $this->assertSame($sha3, EthereumStatic::sha3($k));
        }
    }

    public function testManyWithEthereumSha3()
    {
        foreach ($this->testStrings as $k => $sha3) {
            $val = new EthS($k);
            $x = $this->eth->web3_sha3($val);
            $this->assertSame($sha3, $x->hexVal());
        }
    }
}
