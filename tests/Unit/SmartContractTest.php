<?php
namespace Ethereum;
use Ethereum\SmartContractStatic;

/**
 * EthereumStaticTest
 *
 * @ingroup tests
 */
class SmartContractTest extends EthTest
{

  public function testCreateClass() {

    // Testing simply data type.
    $src = 'contract test { function multiply(uint a) returns(uint d) {   return a * 7;   } }';
    $abi = '[
          {
            "constant": true,
            "inputs": [
              {
                "name": "a",
                "type": "uint256"
              }
            ],
            "name": "multiply",
            "outputs": [
              {
                "name": "d",
                "type": "uint256"
              }
            ],
            "type": "function"
          }
        ]';

    $contract = SmartContractStatic::create($abi);
    $expected_result = '';
    $this->assertEquals($contract,$expected_result);

  }
}


