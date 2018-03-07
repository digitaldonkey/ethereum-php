<?php
namespace Ethereum;
use Ethereum\DataType\EthS;
use Ethereum\TestStaticContract;

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
}
