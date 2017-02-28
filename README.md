# PHP interface to Ethereum JSON-RPC API

### Usage

```
composer require ...

```

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
      $eth->client->eth_protocolVersion();
    }
    catch (\Exception $exception) {
      die ("Unable to connect.");
    }

```

### Documentation
For documentation see the [Ethereum RPC](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html) documentation.
