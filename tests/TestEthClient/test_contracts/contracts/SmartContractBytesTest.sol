pragma solidity 0.4.19;

contract SmartContractBytesTest {

    function b1(bytes b) public pure returns (uint) {
        return b.length;
    }
    function b2(bytes32 b) public pure returns (uint) {
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

     function b3(string b) public pure returns (string) {
         return b;
     }
}
