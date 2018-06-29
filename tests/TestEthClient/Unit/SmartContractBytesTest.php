<?php
namespace Ethereum;
use Ethereum\DataType\EthBytes;
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
    public function testBytes32Length()
    {
        $result = $this->contract->bytes32Length(new EthD32('0x'.md5(1).md5(1)));
        $this->assertEquals(32, $result->val());
    }

    /**
     * function b1(bytes b) public pure returns (uint) {
     *    return b.length;
     * }
     *
     * @throws \Exception
     */
    public function testBytesLength()
    {
        $x = new EthBytes(md5(1).md5(1).md5(1).md5(1));
        $y = $this->contract->bytesLength($x);
        $this->assertEquals(64, $y->val());
    }

    /**
     * function b3(bytes a) public pure returns (bytes) {
     *    return a;
     * }
     *
     * @throws \Exception
     */
    public function testBytesReturn()
    {
        $someBytes = md5(5) . md5(2) . md5(3) . md5(4);
        $x = $this->contract->bytesReturn(new EthBytes($someBytes));
        $this->assertEquals($someBytes, $x->val());
    }

    /**
     * function b3(string b) public pure returns (string) {
     *    return b;
     * }
     *
     * @throws \Exception
    */
    public function testStringReturn()
    {
        $str = 'Hello little string.';
        $strObj = new EthS($str);
        $hex = $strObj->hexVal();
        $x = $this->contract->stringReturn($strObj);
        $this->assertEquals($str, $x->val());
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
