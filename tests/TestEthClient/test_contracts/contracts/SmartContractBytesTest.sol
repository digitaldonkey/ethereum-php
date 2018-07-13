pragma solidity ^0.4.24;

contract SmartContractBytesTest {

    function bytesLength(bytes b) public pure returns (uint) {
        return b.length;
    }

    function bytes32Length(bytes32 b) public pure returns (uint) {
        return b.length;
    }

    // There is no string length. This wouldn't compile in truffle.
    //
    // TypeError: Member "length" not found or not visible
    //   after argument-dependent lookup in string memory.
    //
    // function b3(string b) public pure returns (uint) {
    //        return b.length;
    // }

    function bytesReturn(bytes a) public pure returns (bytes) {
         return a;
     }

     function stringReturn(string b) public pure returns (string) {
         return b;
     }
}
