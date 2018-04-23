# Ethereum-PHP

is a typed PHP-7 interface to [Ethereum JSON-RPC API](https://github.com/ethereum/wiki/wiki/JSON-RPC).

Check out the latest [API documentation](http://ethereum-php.org/dev/).

### Add library in a [composer.json](https://getcomposer.org/doc/01-basic-usage.md#composer-json-project-setup) file

```yaml
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/digitaldonkey/ethereum-php.git"
    }
  ],
  "require": {
    "digitaldonkey/ethereum-php": "dev-dev",
  }
}
```

### Usage


```sh
composer require digitaldonkey/ethereum-php
```

This is the important part of [composer.json](https://github.com/digitaldonkey/ethereum/blob/8.x-1.x/composer.json) in [Drupal Ethereum Module](https://drupal.org/project/ethereum).


```php
try {
  $eth = new EthereumController('http://localhost:8445');
  echo $eth->client->eth_protocolVersion();
}
catch (\Exception $exception) {
  die ("Unable to connect.");
}
```

**Calling Contracts**

You can call (unpayed) functions in smart contracts easily. 

 The json file "$fileName" used is what you get when you compile a contract with [Truffle](truffleframework.com). 

```php
$ContractMeta = json_decode(file_get_contents($fileName));
$contract = new SmartContract(
  $this->data->abi,
  $ContractMeta->networks->{NETWORK_ID}->address,
  new Ethereum(SERVER_URL)
);
$someBytes = new EthBytes('34537ce3a455db6b')
$x = $contract->myContractMethod();
echo $x->val()
```

You can also run tests at smart contracts, check out EthTestClient.

### Limitations & Architecture

Currently all datatypes expect Arrays and lists are supported. 

This library is read-only for now. This means you can retrieve information stored in Ethereum Blockchain.

To *write* to the blockchain you need a to sign transactions with a private key which is not supported yet.


![architecture diagram](https://raw.githubusercontent.com/digitaldonkey/ethereum-php/dev/doxygen-assets/ArchitectureDiagrammCS6.png "Drupal Ethereum architecture")

### Documentation

The API documentation is available at [ethereum-php.org](http://ethereum-php.org/).

For reference see the [Ethereum RPC documentation](https://github.com/ethereum/wiki/wiki/JSON-RPC) and for data encoding [RLP dcumentation](https://github.com/ethereum/wiki/wiki/RLP) in [Ethereum Wiki](https://github.com/ethereum/wiki).

There is also a more readable [Ethereum Frontier Guide](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html) version.

More to read and watch

* [Drupalcon Vienna talk](https://events.drupal.org/vienna2017/sessions/drupal-and-ethereum-blockchain)
* [Drupalcon Baltimore talk](https://events.drupal.org/baltimore2017/sessions/drupal-and-ethereum-blockchain)

