# Getting started

Ethereum-PHP is a typed PHP-7 interface to [Ethereum JSON-RPC API](https://github.com/ethereum/wiki/wiki/JSON-RPC).

### Install the library in a composer file


```yaml
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/digitaldonkey/ethereum-php.git"
    }
  ],
  "require": {
    "digitaldonkey/ethereum-php": "dev-master",
  }
}
```

### Usage


```sh
composer require digitaldonkey/ethereum-php
```

This is the important part of [composer.json](https://github.com/digitaldonkey/ethereum/blob/8.x-1.x/composer.json) in [Drupal Ethereum Module](https://drupal.org/project/ethereum).


#### Extend

```php
use Ethereum\Ethereum_Message;
use Ethereum\Ethereum_Transaction;
use Ethereum\EthereumClient;

class EthereumController extends ControllerBase
{
    public $client;

    public function __construct($host = false)
    {
        if (!$host) {
            $host = 'http://localhost:8445';
        }

        $this->client = new EthereumClient($host);
    }
}
```

#### Use

```php
try {
  $eth = new EthereumController();
  echo $eth->client->eth_protocolVersion();
}
catch (\Exception $exception) {
  die ("Unable to connect.");
}
```

### Documentation

For reference see the [Ethereum RPC documentation](https://github.com/ethereum/wiki/wiki/JSON-RPC) and for data encoding [RLP dcumentation](https://github.com/ethereum/wiki/wiki/RLP) in [Ethereum Wiki](https://github.com/ethereum/wiki).

There is also a more readable [Ethereum Frontier Guide](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html) version.
