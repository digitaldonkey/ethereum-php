<?php
namespace Ethereum;
use Ethereum\DataType\EthBlockParam;
use Ethereum\DataType\EthB;


/**
 * EthQTest
 *
 * @ingroup staticTests
 */
class EthMethodsTest extends TestEthClient
{

    public function __construct(
      ?string $name = null,
      array $data = [],
      string $dataName = ''
    ) {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * This test is bases data by http://codebeautify.org/hex-string-converter.
     * @throw Exception
     */
    public function test_eth_getBlockByNumber()
    {

        $BlockNumber = 13;
        $x = $this->web3->eth_getBlockByNumber(new EthBlockParam($BlockNumber), new EthB(true));
        $this->assertSame($BlockNumber, $x->number->val());

    }

}
