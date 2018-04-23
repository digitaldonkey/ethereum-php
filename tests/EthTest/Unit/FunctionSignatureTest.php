<?php
namespace Ethereum;

/**
 * EthQTest
 *
 * @ingroup staticTests
 */
class FunctionSignatureTest extends TestStatic
{
    public function functionSignatureProvider() {
        // UTF8 text, Kessac256
        return [
            ['multiply(uint256)', '0xc6888fa1'],
            ['test()', '0xf8a8fd6d'],
            ['test(uint256)', '0x29e99f07'],
        ];
    }


    // Following would work, as uint is a alias of int256,
    // but it is not recommended (mandatory?) to use short names for function signatures.
    public function functionSignatureFailProvider() {
        // UTF8 text, Kessac256
        return [
            ['test(uint)', '0x29e99f07'],
            ['test(uint, uint)', '0xeb8ac921'],
        ];
    }

    /**
     * @param $signature
     * @param $ethSignatureHash
     * @dataProvider functionSignatureProvider
     */
    public function testFunctionSignature($signature, $ethSignatureHash)
    {
        $x = EthereumStatic::getMethodSignature($signature);
        $this->assertSame($ethSignatureHash, $x);
    }

    /**
     * @param $signature
     * @param $ethSignatureHash
     * @dataProvider functionSignatureFailProvider
     */
    public function testFunctionSignatureFail($signature, $ethSignatureHash)
    {
        $exception_message_expected = 'No valid (solidity) signature string provided.';
        try {
            EthereumStatic::getMethodSignature($signature);
        } catch (\Exception $exception) {
            $this->assertEquals($exception->getMessage(), $exception_message_expected);
        }
    }
}
