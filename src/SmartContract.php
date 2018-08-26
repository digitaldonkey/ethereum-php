<?php

namespace Ethereum;

use Ethereum\DataType\CallTransaction;
use Ethereum\DataType\EthBlockParam;
use Ethereum\DataType\EthD20;
use Ethereum\DataType\FilterChange;
use \Ethereum\EmittedEvent;

/**
 * %Ethereum SmartContract API for PHP.
 *
 * @ingroup client
 */
class SmartContract
{

    /**
     * @var $abi
     */
    private $abi;

    /**
     * @var $abi
     */
    private $contractAddress;

    /**
     * @var $abi
     */
    private $eth;

    /**
     * @var $events
     * Contract Events array in the form $events[<topic hex>]= \Ethereum\EmittedEvent.
     */
    protected $events;


    /**
     * SmartContract constructor.
     *
     * @param $abi array
     *    Smart contract ABI.
     *
     * @param string $contractAddress
     *    Address of the contract at the network given in $eth.
     *
     * @param \Ethereum\Ethereum $eth
     *    Instance of Ethereum connected to a Ethereum client.
     *
     *
     * @throws \Exception
     */
    public function __construct(array $abi, string $contractAddress, Ethereum $eth)
    {
        $this->abi = new Abi($abi);
        $this->eth = $eth;
        $this->contractAddress = $contractAddress;
        $this->events = $this->abi->getEventsByTopic();
    }

    /**
     * Calling contract functions.
     *
     * @param string $method
     *    Name of the Smart contract method you wish to call.
     *
     * @param $args
     *    Arguments provided.
     *
     * @throws \Exception
     *    If called method is not defined in ABI.
     *
     * @return array|object
     *    Data type object implementing EthDataTypeInterface.
     */
    public function __call(string $method, array $args)
    {
        $call = new CallTransaction(
          new EthD20($this->contractAddress),
          null,
          null,
          null,
          null,
          $this->abi->encodeFunction($method, $args)
        );

        // @todo Maybe we need a smarter default block param handling here.
        // Currently we can only call latest Block.
        $rawReturn = $this->eth->eth_call($call, new EthBlockParam());

        return $this->abi->decodeMethod($method, $rawReturn);
    }


    /**
     * @param \Ethereum\DataType\FilterChange $filterChange
     * @throws \Exception
     *
     * @return \Ethereum\EmittedEvent with emitted Data.
     */
    public function processLog(FilterChange $filterChange) {

        if ($filterChange->address->hexVal() !== $this->contractAddress) {
            return null;
        }

        if (is_array($filterChange->topics)) {
            $topic = $filterChange->topics[0]->hexVal();
            if (isset($this->events[$topic])) {
                $transaction = $this->eth->eth_getTransactionByHash($filterChange->transactionHash);
                // We have a relevant event.
                $event = new EmittedEvent($this->events[$topic], $filterChange, $transaction);
                // Process onEventName handler.
                if (method_exists($this, $event->getHandler())) {
                    call_user_func([$this, $event->getHandler()], $event);
                }
                return $event;
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getAddress() {
        return $this->contractAddress;
    }


    /**
     * Create a array of Contracts from Truffle compiled solidity code.
     *
     * These JSON files are generated, when you run `truffle compile && truffle migrate`.
     *
     * If web3 and networkId are given the array will have initialized contracts.
     *
     * @param $path
     *    Path to the compiled truffle Json files.
     *
     * @param \Ethereum\Ethereum $web3
     *    Instance of a connected web3 client.
     *
     * @param string $networkId
     *    Network Id as defined in truffle.js
     * @see https://github.com/digitaldonkey/ethereum-php/blob/dev/tests/TestEthClient/test_contracts/truffle.js
     *
     * @throws \Exception
     *
     * @return array
     */
    public static function createFromTruffleBuildDirectory($path, $web3 = null, $networkId = null) {
        $return = [];
        foreach (scandir($path) as $fileName) {
            if (strpos($fileName, '.json') !== false) {
                $filePath = $path . '/' . $fileName;
                $file = pathinfo($filePath);
                if($file['extension'] === 'json') {
                    $contractMeta = self::createMetaFromTruffle($filePath);

                    if ($web3 && $networkId) {
                        $address = $contractMeta->networks->{$networkId}->address;
                        if (!class_exists($file['filename']) && $file['filename'] instanceof SmartContract) {
                            // Class exists?
                            trigger_error('Found a json for ' . $file['filename'] . ', but no corresponding contract class name. Initializing with default contract class.', E_USER_WARNING);
                            $return[$file['filename']] = new SmartContract($contractMeta->abi, $address, $web3);
                        }
                        else {
                            $return[$file['filename']] = new $file['filename']($contractMeta->abi, $address, $web3);
                        }
                    }
                    else {
                        $return[$file['filename']] = self::createMetaFromTruffle($filePath);
                    }
                }
            }
        }
        return $return;
    }


    /**
     * @param $filePath
     * @return mixed
     */
    public static function createMetaFromTruffle($filePath) {
        return json_decode(file_get_contents($filePath));
    }


}
