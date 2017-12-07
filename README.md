# Getting started

Ethereum-PHP is a typed PHP-7 interface to [Ethereum JSON-RPC API](https://github.com/ethereum/wiki/wiki/JSON-RPC).

Check out the latest [API documentation](http://ethereum-php.org/dev/).

### Install the library in a composer file


```
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
This is the important part of [composer.json](https://github.com/digitaldonkey/ethereum/blob/8.x-1.x/composer.json) in [Drupal Ethereum Module](https://drupal.org/project/ethereum).


#### Extend

```
use Ethereum\EthereumClient;
use Ethereum\Ethereum_Message;
use Ethereum\Ethereum_Transaction;

class EthereumController extends ControllerBase {

  public $client;

  public function __construct($host = FALSE) {
    if (!$host) {
      $host = 'http://localhost:8445'
    }
    $this->client = new EthereumClient($host);
  }

}
```

#### Use

```
    try {
      $eth = new EthereumController();
      echo $eth->client->eth_protocolVersion();
    }
    catch (\Exception $exception) {
      die ("Unable to connect.");
    }

```

### Documentation
For reference see the [Ethereum RPC documentation](https://github.com/ethereum/wiki/wiki/JSON-RPC) and for data encoding [RLP ddcumentation](https://github.com/ethereum/wiki/wiki/RLP) in [Ethereum Wiki](https://github.com/ethereum/wiki).

There is also a more readyble [Ethereum Frontier Guide](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html) version.
