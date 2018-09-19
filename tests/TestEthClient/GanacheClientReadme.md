# Testing using Ganache Docker 

**TLDR;**

Testing against Smart Contracts on a test-chain is not easy to share. 
Ethereum-PHP comes with some tooling in order to allow also to test against pre-made Transactions.

##Testing with ganach-cli with pre-made Transactions

There are basically two cases

1. The test just depends on a deployed contract<br /> → it would be sufficient to compile and deploy the contracts to the testchain
* The test depends on transactions made on the testchain<br /> → Next to deploying and migrating you would also need to run the TX your test depends on - signing them with a private key

For the second case there is test-data delivered in the folder *GanachClientDb*. 

**Using Docker to share test Data**

For testing I use a Docker based **ganache-cli** to start a local test-chain with pre-filled chain-data. In this setup the contracts are all ready deployed and some Transactions made where tests depend on.

[https://github.com/digitaldonkey/ganache-cli-docker-compose](https://github.com/digitaldonkey/ganache-cli-docker-compose)

Using the "blocks" in the folder ***GanacheClientDb*** as data source in *ganache-cli-docker-compose/***ganache_data** you could run also tests which require transactions to be run in advance.

This dataset corresponds with the Contract data provided in `vendor/tests/TestEthClient/test_contracts/truffle.js` and the build `vendor/tests/TestEthClient/test_contracts/build/contracts`

You may use the following to get a ready test chain corresponding with this test setup.

```
git clone -b Ethereum-PHP-test-data https://github.com/digitaldonkey/ganache-cli-docker-compose.git
cd ganache-cli-docker-compose
docker-compose up

```
With default docker IP settings you should be able to run all tests as defined in phpunit.xml

```
<env name="SERVER_URL" value="http://192.168.99.100:8545"/>
<env name="NETWORK_ID" value="5777"/>
```


##Current tests depending on this setup

**CallableEvents.sol**

Currently only *tests/TestEthClient/Unit/CallableEventsTest.php* require transactions which are in this dataSet only, so you may exclude this tests when running a different Ethereum client.

See also [https://github.com/digitaldonkey/react-box-event-handling](https://github.com/digitaldonkey/react-box-event-handling).