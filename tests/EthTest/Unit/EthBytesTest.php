<?php

namespace Ethereum;

use Ethereum\DataType\EthD;
use Ethereum\DataType\EthBytes;
use Ethereum\DataType\EthS;


/**
 * EthDTest
 *
 * @ingroup staticTests
 */
class EthBytesTest extends TestStatic
{
    /**
     * Testing quantities.
     * @throw Exception
     */
    public function testEthD__simple()
    {

        $x = new EthD('0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertSame($x->val(), '4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertSame($x->hexVal(), '0x4f1116b6e1a6e963efffa30c0a8541075cc51c45');
        $this->assertSame($x->getSchemaType(), "D");
    }


    public function convertDataProvider()
    {
        return [
            // [ABI, rawValue, Expected type class, expected value]
            [
                // See https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L141-L144
                'bytes',
                  '0000000000000000000000000000000000000000000000000000000000000009'
                 .'6761766f66796f726b0000000000000000000000000000000000000000000000'
                ,
                'EthBytes',
                '0x6761766f66796f726b',
            ],
            [
                //See https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L145-L148
                'bytes',
                  '0000000000000000000000000000000000000000000000000000000000000020'
                 .'731a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                ,
                'EthBytes',
                '0x731a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b',
            ],
            [
                //See https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L149-L156
                'bytes',
                  '0000000000000000000000000000000000000000000000000000000000000060'
                 .'131a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                 .'231a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                 .'331a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                ,
                'EthBytes',
                '0x131a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b231a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b331a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b',
            ],
            [
                //See https://github.com/ethereum/web3.js/blob/cd1cfd9db6cacb494884a1824f8562c6440f85df/test/coder.decodeParam.js#L157-L162
                'bytes',
                 '0000000000000000000000000000000000000000000000000000000000000040'
                .'731a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                .'731a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                ,
                'EthBytes',
                '0x731a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b'
                 .'731a3afc00d1b1e3461b955e53fc866dcf303b3eb9f4c16f89e388930f48134b',
            ],
            [
                //See https://github.com/ethereum/web3.js/blob/master/test/coder.decodeParam.js
                'bytes',
                  '000000000000000000000000000000000000000000000000000000000000009f'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff100'
                ,
                'EthBytes',
                '0xffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff'
                 .'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff1',
            ],
            [
                //See https://github.com/ethereum/web3.js/blob/master/test/coder.decodeParam.js
                'bytes',
                  '0000000000000000000000000000000000000000000000000000000000000006'
                 .'c3a40000c3a40000000000000000000000000000000000000000000000000000',
                'EthBytes',
                '0xc3a40000c3a4',
            ],
            [
                // @see https://github.com/ethereumjs/ethereumjs-abi/blob/master/test/index.js
                'bytes',
                  '000000000000000000000000000000000000000000000000000000000000000b'
                 .'68656c6c6f20776f726c64000000000000000000000000000000000000000000',
                'EthBytes',
                '0x68656c6c6f20776f726c64',
            ],

            // @todo IS THIS TEST VALID??
//            [
//                'bytes',
//                '0x000000000000000000000000000000000000000000000000000000000000000d'
//                 .'48656c6c6f2c20776f726c642100000000000000000000000000000000000000',
//                'EthBytes',
//                'Hello, world!',
//            ],
//            [
//                'bytes',
//                '0x0000000000000000000000000000000000000000000000000000000000000004'
//                 .'6461766500000000000000000000000000000000000000000000000000000000',
//                'EthBytes',
//                'dave',
//            ],
            [
                'bytes',
                 '0000000000000000000000000000000000000000000000000000000000000009'
                .'6761766f66796f726b0000000000000000000000000000000000000000000000'
                ,
                'EthBytes',
                '0x6761766f66796f726b',
            ],
//            [
//                'string',
//                '0x0000000000000000000000000000000000000000000000000000000000000020'
//                .'0000000000000000000000000000000000000000000000000000000000000009'
//                .'6761766f66796f726b0000000000000000000000000000000000000000000000'
//                ,
//                'EthS',
//                'gavofyork',
//            ],
        ];
    }


    /**
     * @dataProvider convertDataProvider
     */
    public function testEthBytesTest__createVal($abi, $rawValue, $expClass, $expVal)
    {
        $expClass = "\\Ethereum\DataType\\$expClass";
        $x = $expClass::cretateFromRLP(EthereumStatic::ensureHexPrefix($rawValue));
        $this->assertEquals($expVal, $x->hexVal());
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthBytesTest__createType($abi, $rawValue, $expClass, $expVal)
    {
        $class = "\\Ethereum\DataType\\" . $expClass;
        $x = new $class($expVal);
        $this->assertEquals($expClass, $x->getClassName());
    }


    /**
     * @dataProvider convertDataProvider
     */
    public function testEthBytesTest__createTypeWithAbi($abi, $rawValue, $expClass, $expVal)
    {
        $class = "\\Ethereum\DataType\\" . $expClass;
        $x = new $class($expVal, ['abi' => $abi]);
        $this->assertEquals($expClass, $x->getClassName());
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthBytesTest__converter($abi, $rawValue, $expClass, $expVal)
    {
        $x = new EthD($expVal);
        $y = $x->convertByAbi($abi);
        $this->assertEquals(EthereumStatic::removeHexPrefix($expVal), $y->val());
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testEthBytesTest__converterType($abi, $rawValue, $expClass, $expVal)
    {
        $x = new EthD($expVal);
        $y = $x->convertByAbi($abi);
        $this->assertEquals($expClass, $y->getClassName());
    }

}
