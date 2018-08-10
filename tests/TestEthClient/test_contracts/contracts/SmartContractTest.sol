pragma solidity 0.4.24;

contract SmartContractTest {
    function multiplyWithSeven (uint256 a) public pure returns(uint) {
        return a * 7;
    }

    // uint, int: synonyms for uint256, int256 respectively (not to be used for computing the function selector).
    function multiplyWithSevenUsingAlias (uint a) public pure returns(uint) {
        return a * 7;
    }
}
