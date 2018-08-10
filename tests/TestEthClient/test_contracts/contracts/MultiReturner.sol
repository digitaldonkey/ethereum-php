pragma solidity ^0.4.24;

//  See: https://ethereum.stackexchange.com/a/681/852

contract MultiReturner {

    function getBoolean() public pure returns (bool) {
        bool a = true;
        return (a);
    }

    function getInteger() public pure returns (int) {
        int a = 99;
        return (a);
    }

    function getBytes1() public pure returns (bytes1) {
        bytes1 a = "\x61";
        return (a);
    }

    function getBytes8() public pure returns (bytes8) {
        bytes8 a = "\x61\x61\x61\x61\x61\x61\x61\x61";
        return (a);
    }

    function getBytes16() public pure returns (bytes16) {
        bytes16 a = "\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61\x61";
        return (a);
    }

    function getBytes32() public pure returns (bytes32) {
        bytes32 a = "\x61\x62\x63";
        return (a);
    }

    function getBytes() public pure returns (bytes) {
        bytes memory a = "\x61\x62\x63";
        return (a);
    }

    function getBytesLong() public pure returns (bytes) {
        // 60 bytes
        bytes memory a = "\x61\x62\x63\x61\x62\x63\x61\x62\x63\x63\x61\x62\x63\x61\x62\x63\x61\x62\x63\x63\x61\x62\x63\x61\x62\x63\x61\x62\x63\x63\x61\x62\x63\x61\x62\x63\x61\x62\x63\x63\x61\x62\x63\x61\x62\x63\x61\x62\x63\x63\x61\x62\x63\x61\x62\x63\x61\x62\x63\x63";
        return (a);
    }

    function getTwoBytes32() public pure returns (bytes32, bytes32) {
        bytes32 a = "\x61\x62\x63";
        bytes32 b = "\x78\x79\x7a";
        return (a, b);
    }

    function getDynamicDataMixedTwo() public pure returns (bytes32, bytes) {
        bytes32 a = "\x78\x79\x7a";
        bytes memory b = "\x61\x62\x63";
        return (a, b);
    }

    function getDynamicData() public pure returns (bytes, bytes) {
        bytes memory a = "\x61\x62\x63";
        bytes memory b = "\x78\x79\x7a";
        return (a, b);
    }

    function getDynamicDataMixedOne() public pure returns (bytes, bytes32) {
        bytes memory a = "\x61\x62\x63";
        bytes32 b = "\x78\x79\x7a";
        return (a, b);
    }

    function getDynamicTripple() public pure returns (bytes, bytes, bytes) {
        bytes memory a = "\x61\x62\x63";
        bytes memory b = "\x64\x65\x66";
        bytes memory c = "\x67\x68\x69";
        return (a, b, c);
    }

    function getLotsOfBytes() public pure returns (bytes) {
        bytes memory a = "\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xf1";
        return a;
    }

    function getListOfInteger() public pure returns (uint[10]) {
        uint[10] memory myArray;

        uint8 x = 0;
        while(x < myArray.length)
        {
            myArray[x] = x+1;
            x++;
        }
        return myArray;
    }
}
