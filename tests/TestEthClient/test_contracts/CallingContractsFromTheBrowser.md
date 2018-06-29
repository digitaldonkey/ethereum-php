# Calling contracts fromm the Browser Console

You can call contracts in the Broser console using Web3JS.

**The Contract ABI** 

Abi you find after a truffle compile in build/contracts/[NAME].json

```
const abi = [
    {
      "constant": true,
      "inputs": [],
      "name": "getBoolean",
      "outputs": [
        {
          "name": "",
          "type": "bool"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getInteger",
      "outputs": [
        {
          "name": "",
          "type": "int256"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getBytes1",
      "outputs": [
        {
          "name": "",
          "type": "bytes1"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getBytes32",
      "outputs": [
        {
          "name": "",
          "type": "bytes32"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getBytes",
      "outputs": [
        {
          "name": "",
          "type": "bytes"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getBytesLong",
      "outputs": [
        {
          "name": "",
          "type": "bytes"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getTwoBytes32",
      "outputs": [
        {
          "name": "",
          "type": "bytes32"
        },
        {
          "name": "",
          "type": "bytes32"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getDynamicDataMixedTwo",
      "outputs": [
        {
          "name": "",
          "type": "bytes32"
        },
        {
          "name": "",
          "type": "bytes"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getDynamicData",
      "outputs": [
        {
          "name": "",
          "type": "bytes"
        },
        {
          "name": "",
          "type": "bytes"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getDynamicDataMixedOne",
      "outputs": [
        {
          "name": "",
          "type": "bytes"
        },
        {
          "name": "",
          "type": "bytes32"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "getDynamicTripple",
      "outputs": [
        {
          "name": "",
          "type": "bytes"
        },
        {
          "name": "",
          "type": "bytes"
        },
        {
          "name": "",
          "type": "bytes"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    }
  ];
```


**Get web3js**
Metamasks does not user web3js, but EthJS.

```
// Get web3js instance
var myWeb3 = new Web3(web3.currentProvider)

var myContract = myWeb3.eth.contract(abi)
```

The Address you would get after running `truffle migrate` or any other contract migration.

```
var myContractInstance = myContract.at('0x8f0483125fcb9aaaefa9209d8e9d7b9c8b9fb90f')
```

**Example call from MultiReturner.sol**

```
// Calling for one byte
myContractInstance.getBytes1.call({}, console.log)

// Calling for 32 byte
myContractInstance.getBytes32.call({}, console.log)
```

