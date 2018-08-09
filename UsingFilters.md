# Filters in Ethereum-PHP

It is a good practice to include **events** in your contracts, so that if a function is called you can react in your PHP application on it. 

**Solidity example**

```
pragma solidity ^0.4.24;

contract TestEventHandling {
    event CalledTrigger(address indexed from, uint256 value);

    function triggerEvent() public {
       uint256 myVal = 9999;
       emit CalledTrigger2(msg.sender, myVal);
    }

}

```
In this solidity example `CalledTrigger` is emitted if a user calls the `triggerEvent()` method. 

The logs of the TX will include the data of the CalledTrigger event in 

* topics
	* 	topics[0] Kessac256 of the Event Signature. E.g: `sha3('CalledTrigger(address, uint256)')` --> 32bit hash.
	* 	topics[1-n] Indexed values in the order of definition (n <=4)
* data remaining non indexed Event parameters which need to be ABI decoded

See [eth_getfilterchanges](https://github.com/ethereum/wiki/wiki/JSON-RPC#eth_getfilterchanges).

## Compatibility

There are a lot of issues with filtering in Ethereum, especially considering you may want to use **a service provider like Infura.io** to connect to Ethereum. 

Infura does not support any non SSH [filter Methods](https://github.com/INFURA/infura/blob/master/docs/source/index.html.md#supported-json-rpc-methods). So if you depend Infura, you need to consider it in your architecture. 

In the future [EthQl](https://github.com/ConsenSys/ethql) might be a alternative approach.

Ethereum-PHP tries to be compatible with ANY client, so I don't consider Filters consistently working. 


## Architectural considerations

The concept of Event driven filters does not really match PHP. 

**Using filters**

Using Filters with a Symfony EventDispatcher might be a solution if you are actually using a Ethereum node which supports filters, but you still need to poll for your events every time a new Block is created. This might be an option if you want to search for Data in any new Block, but you will need to set up a cronjob to call getFilterChanges in the frequency of block time.

**User triggered events**

Currently suggesting a simplified Ajax based Approach: 

* User submits a TX in the frontend and submits the TX receipt hash/id to your PHP app
* Use eth_getTransactionReceipt() to get the logs data and handle the emitted events on the PHP side

More below.


**Event Listener**

In some cases you might want to index all events in a Blockchain or listen continuously to contract events whenever a new Block is generated. 

Natively PHP is very bad at this. I implemented a [Block/Event listener](https://github.com/digitaldonkey/ethereum-php-eventlistener) based on [ReactPHP](https://github.com/reactphp/react) which allows Block processing and Event listening. 

Truffle integration: This approach is very easy to integrate if you are using Truffle for your Contract code. 

```php 
// Extend a \Ethereum\SmartContract with EventHandlers
class CallableEvents extends SmartContract {
  public function onCalledTrigger1 (EthEvent $event) {
    echo '### ' . substr(__FUNCTION__, 2) . "(\Ethereum\EmittedEvent)\n";
    var_dump($event);
  }
  public function onCalledTrigger2 (EthEvent $event) {
    echo '### ' . substr(__FUNCTION__, 2) . "(\Ethereum\EmittedEvent)\n";
    var_dump($event);
  }
}

$web3 = new Ethereum('http://192.168.99.100:8545');
$networkId = '5777';

// Contract Classes must have same name as the solidity classes for this to work.
$contracts = SmartContract::createFromTruffleBuildDirectory(
  'YOUR/truffle/build/contracts',
   $web3,
   $networkId
);

// process any Transaction from current Block to the future.
new ContractEventProcessor(
  $web3,
  $contracts,
  'latest',
  'latest'
);
```

See [integration-with-truffle-and-contract-events](https://github.com/digitaldonkey/ethereum-php-eventlistener#integration-with-truffle-and-contract-events).


## Note on weird return values

The return of `eth_getFilterChanges()` depends on which method you use to setup the filter. Filter added with 

* eth_newBlockFilter (block hashes) -> returns [D32]
* eth_newPendingTransactionFilter (transaction hashes) -> returns [D32]
* eth_newFilter -> returns [FilterChange]

This is also not correctly reflected in [ethjs-schema](https://github.com/ethjs/ethjs-schema/issues/10).

[Source Ethereum Wiki](https://github.com/ethereum/wiki/wiki/JSON-RPC#returns-42)

## Current recommendation

1. Get the TX-hash from frontend interaction
2. Query the results in PHP using eth_getTransactionReceipt(TX-hash)
3. The TransactionReceipt contains an array "logs" which contains FilterChange objects
4. Use contractInstance->processLog(FilterChange) to get the decoded Contract event data

Example  *tests/TestEthClient/Unit/CallableEventsTest.php*
