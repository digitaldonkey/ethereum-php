<?php
/**
 * @file
 *  %Ethereum Testing
 *
 * It allows testing against Ethereum clients via JsonRPC.
 *
 */

namespace Ethereum;

use Ethereum\TestStatic;
use Exception;

/**
 * @defgroup ethereumTests EthereumClientTest
 * @ingroup tests
 *
 * Testing via JsonRPC against %Ethereum clients.
 */

/**
 * Abstract base class for Tests
 *
 * @ingroup ethereumTests
 *
 * Exclude by running only the static tests
 *    `vendor/bin/phpunit --testsuite EthereumPhp`
 *
 *  - requires an available Ethereum Node running.
 *  -
 *  -  The test contracts must be deployed and the contract address set
 *     corresponding with the network id.
 *  -  You want to use truffle to deploy the contracts and generate the
 *      metadata file
 *      test_contracts/build/contracts/SmartContractTest.json
 *  - valid Environment variables SERVER_URL and NETWORK_ID
 *
 * Easiest way to get started is using
 *  - Ganache as a testserver truffleframework.com/ganache/
 *  - Truffle to deploy the contracts
 *      `npm install -g truffle && cd test_contracts && truffle build &&
 *   truffle migrate`
 *
 *  Default is the Ganache default config.
 *  `<env name="SERVER_URL" value=""/>
 *   <env name="NETWORK_ID" value="5777"/>`
 *
 *
 *
 * You may define this vars in your shell before running tests.
 *  NETWORK_ID='1'
 *  SERVER_URL='http://localhost:8545'
 *  export NETWORK_ID
 *  export SERVER_URL
 *
 * NETWORK_ID is used to get the Contract Address from Truffle deployed
 *   contracts. See build/contracts *.json
 *
 * "networks": {
 *  NETWORK_ID: {
 *  "events": {},
 *  "links": {},
 *  "address": "0x345ca3e014aaf5dca488057592ee47305d9b3e10"
 *  },
 */
abstract class TestEthMainnet extends TestStatic
{

    /**
     * @var \Ethereum\Ethereum
     */
    protected $web3;

    /**
     * %Ethereum Test Base class
     *
     * @throws Exception
     *    If  NETWORK_ID or SERVER_URL are not defined env vars in phpunit.xml.
     */
    public static function setUpBeforeClass()
    {

        $serverUrl = getenv("INFURA_MAINNET_URL");
        if ($serverUrl) {
            if (!defined('INFURA_MAINNET_URL')) {
                define('INFURA_MAINNET_URL', $serverUrl);
            }
        }
        else {
            throw new \Exception(
                'INFURA_MAINNET_URL must be defined in phpunit.xml or as ENV variable.'
            );
        }

        if (substr(INFURA_MAINNET_URL, 0, 4) !== 'http') {
            throw new \Exception(
                'INFURA_MAINNET_URL must start with http or https. INFURA_MAINNET_URL started with ' . substr(INFURA_MAINNET_URL, 0, 12) . '...'
            );
        }
    }

    /**
     * Create Ethereum instance.
     *
     * @throws Exception
     *   If Smart contracts have not been compiled.
     */
    protected function setUp()
    {
        $this->web3 = new Ethereum(INFURA_MAINNET_URL);
    }

}
