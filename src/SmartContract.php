<?php

namespace Ethereum;

use Ethereum\DataType\CallTransaction;
use Ethereum\DataType\EthBlockParam;
use Ethereum\DataType\EthD20;
use Exception;


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
     * Get valid number lengths.
     *
     * @param $abi array
     *    Smart contract ABI.
     *
     * @param string $contractAddress
     *    Address of the contract at the network given in $eth.
     *
     * @param Ethereum $eth
     *    Instance of Ethereum connected to a Ethereum client.
     */
    public function __construct($abi, $contractAddress, $eth)
    {
        $this->abi = new Abi($abi);
        $this->eth = $eth;
        $this->contractAddress = $contractAddress;
    }

    /**
     *
     * @todo Maybe we need a smarter default block param handling here.
     *      Currently we can only call latest Block.
     *
     * @param string $method
     *    Name of the Smart contract method you wish to call.
     *
     * @param $args
     *    Arguments provided.
     *
     * @throws Exception
     *    If called method is not defined in ABI.
     *
     * @return array|object
     *    Data type object implementing EthDataTypeInterface.
     *
     * @todo: ARRAY or OBJECT? How to make it consistent??
     */
    public function __call($method, $args)
    {

        $XXX = $this->abi->encodeFunction($method, $args);

        $call = new CallTransaction(
          new EthD20($this->contractAddress),
          null,
          null,
          null,
          null,
          $this->abi->encodeFunction($method, $args)
        );

        // @todo Defaulting to latest Block here :/
        $rawReturn = $this->eth->eth_call($call, new EthBlockParam());

        return $this->abi->decode($method, $rawReturn);
    }

}
