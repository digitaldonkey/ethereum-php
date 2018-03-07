<?php
namespace Ethereum;
use Ethereum\EthS;
use Ethereum\EthTestContract;

/**
 * EthQTest
 *
 * @ingroup tests
 */
class FunctionSignatureTest extends EthTest
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
