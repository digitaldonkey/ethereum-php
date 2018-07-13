<?php

namespace Ethereum;

use Ethereum\DataType\EthS;

/**
 * EthereumStaticTest
 *
 * @ingroup ethereumTests
 */
class MultiReturner extends TestEthContract
{

    /**
     * NON RLP
     *
     * function getBoolean() public pure returns (bool) {
     * bool a = true;
     * return (a);
     * }
     */
    public function testGetBoolean()
    {
        $result = $this->contract->getBoolean();
        $this->assertEquals(true, $result->val());
    }

    /**
     * NON RLP
     *
     * function getInteger() public pure returns (int) {
     * int a = 99;
     * return (a);
     * }
     */
    public function testGetInteger()
    {
        $result = $this->contract->getInteger();
        $this->assertEquals(99, $result->val());
    }

    /**
     * NON RLP
     *
     * function getBytes1() public pure returns (bytes1) {
     * bytes1 a = "\x61";
     * return (a);
     * }
     */
    public function testGetBytes1()
    {
        $result = $this->contract->getBytes1();
        // @todo THIS IS WRONG Solidity will give me a 0x61. So we should cut off at "61"
        // $this->assertEquals('6100000000000000000000000000000000000000000000000000000000000000', $result->val());
        $this->assertEquals('61', $result->val());
    }

    public function testGetBytes8()
    {
        $result = $this->contract->getBytes8();
        $this->assertEquals('6161616161616161', $result->val());
    }


    public function testGetBytes16()
    {
        $result = $this->contract->getBytes16();
        $this->assertEquals('61616161616161616161616161616161', $result->val());
    }

    /**
     * NON RLP
     *
     * function getBytes32() public pure returns (bytes32) {
     * bytes32 a = "\x61\x62\x63";
     * return (a);
     * }
     */
    public function testGetBytes32()
    {
        $result = $this->contract->getBytes32();
        $this->assertEquals('6162630000000000000000000000000000000000000000000000000000000000',
          $result->val());
    }

    /**
     * Simple RLP
     *
     * function getBytes() public pure returns (bytes) {
     * bytes memory a = "\x61\x62\x63";
     * return (a);
     * }
     */
    public function testGetBytes()
    {
        $result = $this->contract->getBytes();
        $this->assertEquals('616263', $result->val());
    }

    /**
     * function getBytesLong() public pure returns (bytes)
     *  returns 60 bytes.
     *
     */
    public function testGetBytesLong()
    {
        $result = $this->contract->getBytesLong();
        $this->assertEquals('616263616263616263636162636162636162636361626361626361626363616263616263616263636162636162636162636361626361626361626363',
          $result->val());
    }

    /**
     * TWO bytes32 values returned
     *
     * function getTwoBytes32() public pure returns (bytes32, bytes32) {
     * bytes32 a = "\x61\x62\x63";
     * bytes32 b = "\x78\x79\x7a";
     * return (a, b);
     * }
     */
    public function testGetTwoBytes32()
    {
        $result = $this->contract->getTwoBytes32();

        $a = $result[0]->val() === '6162630000000000000000000000000000000000000000000000000000000000';
        $b = $result[1]->val() === '78797a0000000000000000000000000000000000000000000000000000000000';
        $expect = ($a && $b);
        $this->assertTrue($expect);
    }

    /**
     * function getDynamicDataMixedTwo() public pure returns (bytes32, bytes) {
     *   bytes32 a = "\x78\x79\x7a";
     *   bytes memory b = "\x61\x62\x63";
     *   return (a, b);
     * }
     */
    public function testGetDynamicDataMixedTwo()
    {
        $result = $this->contract->getDynamicDataMixedTwo();

        $this->assertEquals('78797a0000000000000000000000000000000000000000000000000000000000',
          $result[0]->val());
        $this->assertEquals('616263', $result[1]->val());
    }

    /**
     * function getDynamicData() public pure returns (bytes, bytes) {
     * bytes memory a = "\x61\x62\x63";
     * bytes memory b = "\x78\x79\x7a";
     * return (a, b);
     * }
     */
    public function testGetDynamicData()
    {
        $result = $this->contract->getDynamicData();
        $this->assertEquals('616263', $result[0]->val());
        $this->assertEquals('78797a', $result[1]->val());
    }

    /**
     * function getDynamicTripple() public pure returns (bytes, bytes, bytes) {
     *   bytes memory a = "\x61\x62\x63";
     *   bytes memory b = "\x64\x65\x66";
     *   bytes memory c = "\x67\x68\x69";
     *   return (a, b, c);
     * }
     */
    public function testGetDynamicTripple()
    {
        $result = $this->contract->getDynamicTripple();
        $this->assertEquals('616263', $result[0]->val());
        $this->assertEquals('646566', $result[1]->val());
        $this->assertEquals('676869', $result[2]->val());
    }

    /**
     * function getDynamicDataMixedOne() public pure returns (bytes, bytes32) {
     *   bytes memory a = "\x61\x62\x63";
     *   bytes32 b = "\x78\x79\x7a";
     *   return (a, b);
     * }
     */
    public function testGetDynamicDataMixedOne()
    {
        $result = $this->contract->getDynamicDataMixedOne();
        $this->assertEquals('616263', $result[0]->val());
        $this->assertEquals('78797a0000000000000000000000000000000000000000000000000000000000', $result[1]->val());
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
            $this->assertEquals($exception->getMessage(),
              $exception_message_expected);
        }
    }


    /**
     * function getLotsOfBytes() public pure returns (bytes) {
     *   bytes memory a = "\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xf1";
     *   return a; // > 159 bytes
     * }
     */
    public function testGetLotsOfBytes()
    {
        $result = $this->contract->getLotsOfBytes();
        $this->assertEquals(
          '0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff1',
          $result->hexVal()
        );
    }


    /**
     * function getListOfInteger() public pure returns (uint[10]) {
     *   uint[10] memory myArray;
     *   uint8 x = 0;
     *   while(x < myArray.length) {
     *     myArray[x] = x+1;
     *     x++;
     *   }
     *   return myArray;
     * }
     */

    // @todo Implement Lists.

//    public function testGetListOfInteger()
//    {
//        $result = $this->contract->getListOfInteger();
//        $VAL = $result->val();
//        $this->assertEquals(
//          '--> TBD',
//          $result->hexVal()
//        );
//    }



}
