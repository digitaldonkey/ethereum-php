<?php
namespace Ethereum;

use Ethereum\DataType\EthQ;

/**
 * EthereumStaticTest
 *
 * @ingroup ethereumTests
 */
class SmartContractTest extends TestEthContract
{

    /**
     * The used contract is referenced by its name
     *
     * "class SmartContractTest" ==> ../test_contracts/build/SmartContractTest.json
     *
     * Truffle builds the json file when running
     *
     *      truffle compile && truffle migrate
     *
     * The source file is ../test_contracts/contracts/SmartContractTest.sol
    */
    public function testSimpleContract()
    {
        $number = 2;
        $result = $this->contract->multiplyWithSeven(
            new EthQ($number, ['abi'=> 'uint256'])
        );
        $this->assertEquals($number*7, $result->val());
    }


    public function testSimpleContractUsingAlias()
    {
        $number = 2;
        $result = $this->contract->multiplyWithSevenUsingAlias(
          new EthQ($number, ['abi'=> 'uint256'])
        );
        $this->assertEquals($number*7, $result->val());
    }

}


