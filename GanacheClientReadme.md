# Testing using Ganache Docker 

You may use a **docker-compose** to start a local test-chain using **ganache-cli**.

[https://github.com/digitaldonkey/ganache-cli-docker-compose](https://github.com/digitaldonkey/ganache-cli-docker-compose)

Using the "blocks" in the folder ***GanacheClientDb*** as data source in *ganache-cli-docker-compose/***ganache_data** you could run also tests which require transactions to be run in advance.

This dataset corresponds with the Contract data provided in *vendor/tests/TestEthClient/test_contracts/truffle.js*

###Currently

**CallableEvents.sol**

Currently only *tests/TestEthClient/Unit/CallableEventsTest.php* require transactions which are in this dataSet only, so you may exclude this tests when running a different Ethereum client.

See also [https://github.com/digitaldonkey/react-box-event-handling](https://github.com/digitaldonkey/react-box-event-handling).