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
 *      `npm install -g truffle && cd test_contracts && truffle build && truffle migrate`
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
 * NETWORK_ID is used to get the Contract Address from Truffle deployed contracts.
 * See build/contracts *.json
 *
 * "networks": {
 *  NETWORK_ID: {
 *  "events": {},
 *  "links": {},
 *  "address": "0x345ca3e014aaf5dca488057592ee47305d9b3e10"
 *  },
 *
 */
abstract class TestEthContract extends TestEthClient {

    protected $data;
    protected $contract;

    /**
     * This constructs a smart contract
     *
     * @throws Exception
     *   If Smart contracts have not been compiled.
     */
    protected function setUp()
    {
        /**
         * @var $contractName
         *    * The contract should be deployed to the network reachable at
         *    SERVER_URL.
         *    * MetaData is loaded from ../test_contracts/build/contracts/$contract.json
         *    * The address of the deployed contract is loaded from
         *        MetaData->netwoks->NETWORK_ID->address.
         */
        $contractName = (new \ReflectionClass($this))->getShortName();
        $fileName = getcwd() . '/tests/TestEthClient/test_contracts/build/contracts/' . $contractName . '.json';

        if (!file_exists($fileName)) {
            throw new Exception(
                'You need to compile and deploy the smartcontracts located in TestEthClient/test_contracts/contracts using truffle.'
                . ' (npm -i -g truffle && truffle compile && truffle migrate)'
            );
        }

        $this->data = json_decode(file_get_contents($fileName));
        $this->contract = new SmartContract(
            $this->data->abi,
            $this->data->networks->{NETWORK_ID}->address,
            new Ethereum(SERVER_URL)
        );
    }
}
