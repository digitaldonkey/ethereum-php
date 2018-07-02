<?php
namespace Ethereum;
use Ethereum\DataType\EthBytes;
use Ethereum\DataType\EthS;
use Ethereum\TestStatic;

/**
 * EthQTest
 *
 * @ingroup staticTests
 */
class EthSTest extends TestStatic
{


    public function convertDataProvider()
    {
        return [
            // [ABI, rlpValue, Expected type class, expected value]
            [
                // @see https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L204-L206
                'string',
                '0000000000000000000000000000000000000000000000000000000000000009'.
                '6761766f66796f726b0000000000000000000000000000000000000000000000'
                ,
                'EthS',
                'gavofyork',
            ],
            [
                // @see: https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L207-L210
                'string',
                '0000000000000000000000000000000000000000000000000000000000000008'.
                'c383c2a4c383c2a4000000000000000000000000000000000000000000000000'
                ,
                'EthS',
                'Ã¤Ã¤',
            ],
            [
                // @see: https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L211-L214
                'string',
                '0000000000000000000000000000000000000000000000000000000000000002'.
                'c3bc000000000000000000000000000000000000000000000000000000000000'
                ,
                'EthS',
                'ü',
            ],
            [
                // @see: https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L215-L218
                'string',
                '0000000000000000000000000000000000000000000000000000000000000002'.
                'c383000000000000000000000000000000000000000000000000000000000000'
                ,
                'EthS',
                'Ã',
            ],
            [
                // @see: https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L215-L218
                'string',
                '000000000000000000000000000000000000000000000000000000000000003e'.
                '77656c636f6d6520746f20657468657265756d2e2077656c636f6d6520746f20'.
                '657468657265756d2e2077656c636f6d6520746f20657468657265756d2e0000'
                ,
                'EthS',
                'welcome to ethereum. welcome to ethereum. welcome to ethereum.',
            ],
            [
                // @see: https://github.com/ethereumjs/ethereumjs-abi/blob/71f123b676f2b2d81bc20f343670d90045a3d3d8/test/index.js#L228-L235
                'string',
                '000000000000000000000000000000000000000000000000000000000000000b'.
                '68656c6c6f20776f726c64000000000000000000000000000000000000000000'
                ,
                'EthS',
                'hello world',
            ],
            [
                // @see: https://github.com/ethereumjs/ethereumjs-abi/blob/71f123b676f2b2d81bc20f343670d90045a3d3d8/test/index.js#L600-L605
                'string',
                '0000000000000000000000000000000000000000000000000000000000000017'.
                '657468657265756d20737ac3a16dc3ad74c3b367c3a970000000000000000000'
                ,
                'EthS',
                'ethereum számítógép',
            ],
            [
                // @see: https://github.com/ethereumjs/ethereumjs-abi/blob/71f123b676f2b2d81bc20f343670d90045a3d3d8/test/index.js#L616-L620
                'string',
                '0000000000000000000000000000000000000000000000000000000000000018'.
                'e4b8bae4bb80e4b988e982a3e4b988e8aea4e79c9fefbc9f0000000000000000'
                ,
                'EthS',
                '为什么那么认真？',
            ],
            [
                // @see: https://github.com/ethereumjs/ethereumjs-abi/blob/71f123b676f2b2d81bc20f343670d90045a3d3d8/test/index.js#L89-L95
                'string',
                '00000000000000000000000000000000000000000000000000000000000000c2'.
                '2068656c6c6f20776f726c642068656c6c6f20776f726c642068656c6c6f2077'.
                '6f726c642068656c6c6f20776f726c64202068656c6c6f20776f726c64206865'.
                '6c6c6f20776f726c642068656c6c6f20776f726c642068656c6c6f20776f726c'.
                '64202068656c6c6f20776f726c642068656c6c6f20776f726c642068656c6c6f'.
                '20776f726c642068656c6c6f20776f726c642068656c6c6f20776f726c642068'.
                '656c6c6f20776f726c642068656c6c6f20776f726c642068656c6c6f20776f72'.
                '6c64000000000000000000000000000000000000000000000000000000000000'
                ,
                'EthS',
                ' hello world hello world hello world hello world  hello world hello world hello world hello world  hello world hello world hello world hello world hello world hello world hello world hello world',
            ],
            [
                // @see: https://github.com/ethereumjs/ethereumjs-abi/blob/71f123b676f2b2d81bc20f343670d90045a3d3d8/test/index.js#L105-L111
                'string',
                '000000000000000000000000000000000000000000000000000000000000001f'.
                '6120726573706f6e736520737472696e672028756e737570706f727465642900'
                ,
                'EthS',
                'a response string (unsupported)',
            ],
        ];
    }


    //

    /**
     * This test is bases data by http://codebeautify.org/hex-string-converter.
     * @throw Exception
     */
    public function testEthS__types()
    {

        $x = new EthS('Hello World');
        $this->assertEquals($x->val(), "Hello World");
        $this->assertEquals($x->getSchemaType(), "S");
    }

    // THE FOLLOWING TWO TEST ARE WRONG!
    // @depreciated
    //      -> If you implemented something like that it will not work anymore.
    //
    //public function testEthS__hexToString()
    //{
    //
    //    $x = new EthS('0x48656c6c6f20576f726c64');
    //    $this->assertEquals($x->val(), "Hello World");
    //}
    //public function testEthS__stringToHex()
    //{
    //    $x = new EthS("Hello World");
    //    $this->assertEquals($x->hexVal(), '0x48656c6c6f20576f726c64');
    //}

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthSTest__create($abi, $rlpValue, $expClass, $utf8Val)
    {
        $x = EthS::cretateFromRLP(EthereumStatic::ensureHexPrefix($rlpValue));
        $this->assertEquals($utf8Val, $x->val());
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthSTest__convertHexDataToHexStr($abi, $rlpValue, $expClass, $utf8Val)
    {
        $x = EthBytes::cretateFromRLP(EthereumStatic::ensureHexPrefix($rlpValue));
        $y = $x->convertByAbi($abi);
        $this->assertEquals($utf8Val, $y->val());
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthSTest__convertUtf8ToData($abi, $rlpValue, $expClass, $utf8Val)
    {
        $x = new EthS($utf8Val);
        $y = $x->convertByAbi('bytes');
        $z = EthBytes::cretateFromRLP(EthereumStatic::ensureHexPrefix($rlpValue));
        $this->assertEquals($y->hexVal(), $z->hexVal());
    }

    // DOES NOT MAKE SENSE RIGHT NOW, just duplicates. DataSet has no plain Hex value.
//    /**
//     * @dataProvider convertDataProvider
//     */
//    public function testEthSTest__Utf8ToHex($abi, $rlpValue, $expClass, $utf8Val)
//    {
//        $x = new EthS($utf8Val);
//        $this->assertEquals(EthereumStatic::ensureHexPrefix($rlpValue), $x->hexVal());
//    }
//
//    /**
//     * @dataProvider convertDataProvider
//     */
//    public function testEthSTest__HexToUtf8($abi, $rlpValue, $expClass, $utf8Val)
//    {
//        $x = EthS::cretateFromRLP(EthereumStatic::ensureHexPrefix($rlpValue));
//        $this->assertEquals($utf8Val, $x->val());
//    }

}
