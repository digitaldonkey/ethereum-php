pragma solidity ^0.4.24;

contract CallableEvents {

    address _owner;

    // Event allowing listening to newly signed Accounts (?)
    event CalledTrigger1 (address indexed from);
    event CalledTrigger2 (address indexed from, uint256 value);
    event CalledTrigger3 (address indexed from, uint256 val1, uint256 val2);
    event CalledTrigger4 (uint256 val1, uint256 val2);
    event CalledTrigger5 (uint256 indexed val1, uint256 indexed val2);
    event CalledTrigger6 (address  from, uint256 timestamp, uint256 blockNumber);
    event MoneyReceived (address indexed from, uint256 value);

    function contractExists () public pure returns (bool result){
        return true;
    }

    // Administrative below
    constructor() public {
      _owner = msg.sender;
    }

    function triggerEvent1() public {
        emit CalledTrigger1(msg.sender);
    }

    function triggerEvent2() public {
       uint256 myVal = 9999;
       emit CalledTrigger2(msg.sender, myVal);
    }

    function triggerEvent3() public {
       uint256 myVal = 9999;
       emit CalledTrigger3(msg.sender, myVal, myVal);
    }

    function triggerEvent4() public {
       uint256 myVal = 9999;
       emit CalledTrigger4(myVal, myVal);
    }

    function triggerEvent5() public {
       uint256 myVal = 9999;
       emit CalledTrigger5(myVal, myVal);
    }

    // Timestamp could be modified by miner.
    // For time critical events you should only rely on block number.
    // See: https://ethereum.stackexchange.com/a/9859/852
    function triggerEvent6() public {
       emit CalledTrigger6(msg.sender, unixTime(), block.number);
    }

    function () public payable {
        emit MoneyReceived(msg.sender, msg.value);
    }

    /**
     * Returns Unix Timestamp
     * E.g: https://www.unixtimestamp.com
     */
    function unixTime() internal view returns (uint256){
        return now;
    }


//    function getTheMoney() public {
//        if (msg.sender == _owner) {
//          _owner.transfer(address(this).balance);
//        }
//    }

    function adminDeleteRegistry() public {
        if (msg.sender == _owner) {
          selfdestruct(_owner);
        }
    }

}
