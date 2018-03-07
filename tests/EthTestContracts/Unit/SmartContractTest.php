<?php
namespace Ethereum;
use Ethereum\SmartContract;
use Ethereum\EthQ;

/**
 * EthereumStaticTest
 *
 * @ingroup tests
 */
class SmartContractTest extends EthTestContract
{

    public function testCreateClass()
    {
        /**
        * @var $contractName
        *    * The contract should be deployed to the network reachable at
        *    SERVER_URL.
        *    * MetaData is loaded from ../test_contracts/build/contracts/$contract.json
        *    * The address of the deployed contract is loaded from
        *        MetaData->netwoks->NETWORK_ID->address.
        */
        $contractName = 'SmartContractTest';

        $data = json_decode(file_get_contents(
            getcwd() . '/tests/EthTestContracts/test_contracts/build/contracts/'
            . $contractName . '.json'
        ));

        $abi = $data->abi;
        $contract_address = $data->networks->{NETWORK_ID}->address;

        $contract = new SmartContract(
          $abi,
          $contract_address,
          new Ethereum(SERVER_URL)
        );

        $number = 2;
        $result = $contract->multiplyWithSeven(
          new EthQ($number, ['abi'=> 'uint256'])
        );
        $this->assertEquals($number*7, $result->val());
    }
}


