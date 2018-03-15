<?php
namespace Ethereum;
use Ethereum\DataType\EthData;
use Ethereum\SmartContract;
use Ethereum\DataType\EthD32;
use Ethereum\DataType\EthS;
/**
 * EthereumStaticTest
 *
 * @ingroup ethereumTests
 */
class SmartContractBytesTest extends TestEthContract
{
    /**
     *
     * function b2(bytes32 b) public pure returns (uint) {
     *   return b.length;
     * }
     * @throws \Exception
     */
    public function testBytes32()
    {
        $result = $this->contract->b2(new EthD32('0x'.md5(1).md5(1)));
        $this->assertEquals(32, $result->val());
    }

    /**
     *
     * @todo Shouldn't we fail of wrong type? Or do we allow a parent instance?
     *       Here "string" and "bytes" are both encoded the same and children of EthD.
     *
     * function b1(bytes b) public pure returns (uint) {
     *    return b.length;
     * }
     *
     * @throws \Exception
     */
    public function testBytes()
    {
        $exception_message_expected = 'Dynamic ABI type "bytes" is not implemented yet.';
        try {
            $this->contract->b1(new EthData('0x'.md5(1).md5(1).md5(1).md5(1)));
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }


    /**
     * function b3(string b) public pure returns (string) {
     *    return b;
     * }
     *
     * @throws \Exception
    */
    public function testString()
    {
        $exception_message_expected = 'Dynamic ABI type "string" is not implemented yet.';
        try {
            $this->contract->b3(new EthS('Hello!!'));
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }


    /**
     * Test undefined Method
     *
     * @throws \Exception
     */
    public function testUndefinedMethod()
    {
        $exception_message_expected = 'Called undefined contract method: testUndefined.';
        try {
            $x = new EthS('Hello!!');
            $this->contract->testUndefined($x);
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }
}
