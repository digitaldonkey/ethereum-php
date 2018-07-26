<?php

namespace Ethereum;

use Ethereum\DataType\CallTransaction;
use Ethereum\DataType\EthBlockParam;
use Ethereum\DataType\EthD20;
use Ethereum\DataType\FilterChange;

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
     * Contract Events array in the form $events[<topic hex>]= \Ethereum\Event.
     */
    private $events;


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
     * @return array Event emitted Data.
     */
    public function processLog(FilterChange $filterChange) {

        if ($filterChange->address->hexVal() !== $this->contractAddress) {
            return null;
        }

        if (is_array($filterChange->topics)) {
            $topic = $filterChange->topics[0]->hexVal();
            if (isset($this->events[$topic])) {
                // We have a relevant event.
                return $this->events[$topic]->decode($filterChange);
            }
        }
        return null;
    }
}
