pragma solidity 0.4.23;

//  See: https://ethereum.stackexchange.com/a/681/852

contract MultiReturner {
    function getData() public pure returns (bytes32, bytes32) {
        bytes32 a = "abcd";
        bytes32 b = "wxyz";
        return (a, b);
    }

    function getDynamicData() public pure returns (bytes, bytes) {
        bytes memory A = '0x616263';
        bytes memory B = '0x78797A';
        return (A, B);
    }
}
