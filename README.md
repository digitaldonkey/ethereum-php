# PHP interface to Ethereum JSON-RPC API

### Usage

```sh
composer require digitaldonkey/ethereum-php
```

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
    $eth->client->eth_protocolVersion();
} catch (\Exception $exception) {
    die ("Unable to connect.");
}
```

### Documentation

For documentation see the [Ethereum RPC](http://ethereum.gitbooks.io/frontier-guide/content/rpc.html) documentation.
