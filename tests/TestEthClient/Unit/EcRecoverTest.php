<?php
namespace Ethereum;
use Ethereum\DataType\EthS;
use Ethereum\TestEthClient;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup staticTests
 */
class EcRecoverTest extends TestEthClient {

    public function ecRecoverDataProvider() {
        // Address, challenge, Signature
        return [
          [
            '0xf17f52151ebef6c7334fad080c5704d77216b732',
            'Welcome back!\r\nPlease sign to log-in today (Mon, 04/23/2018 - 18:36).\r\n'],
            '0x54d46d72c9a3ac6d81fff8a2ab052c1c2f5d6e2997fc56400916e1498171d11812c1e21720f1bbb7ee2f1589dd59b036d5a8dff191dcb88317a1316f646140ab1c',
        ];
    }

    /**
     * @param $address
     * @param $challenge
     * @param $signature
     *
     * @dataProvider ecRecoverDataProvider
     */
    public function restoreAddressTest($address, $challenge, $signature)
    {
        $web3 = new Ethereum(SERVER_URL);
        $this->assertSame($signature, $web3->contractEcRecover($text));
    }

}
