<?php

namespace Ethereum;

use Exception;
use Ethereum\DataType\CallTransaction;
use Ethereum\DataType\EthD20;
use Ethereum\DataType\EthD;
use Ethereum\DataType\EthBlockParam;

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
        $this->abi = $abi;
        $this->eth = $eth;
        $this->contractAddress = $contractAddress;
    }


    /**
     *
     * @todo Maybe we need a smarter default block param handling here.
     *      Currently we can only call latest Block.
     *
     * @param string $methodName
     *    Name of the Smart contract method you wish to call.
     *
     * @param $args
     *    Arguments provided.
     *
     * @throws Exception
     *    If called method is not defined in ABI.
     *
     * @return object
     *    Data type object implementing EthDataTypeInterface.
     */
    public function __call($methodName, $args)
    {
        $m = $this->getMethod($methodName);
        $sign = $this->getMethodSignature($m);
        $params = $this->getMethodParams($m, $args);

        $call = new CallTransaction(
          new EthD20($this->contractAddress),
          NULL,
          NULL,
          NULL,
          NULL,
          new EthD($sign . $params)
        );

        $return = $this->eth->eth_call($call, new EthBlockParam());

        if ($return->isPrimitive()) {
            // Convert/validate return value.
            $returnTypeAbi = $m->outputs[0]->type;
            $return = $return->convertByAbi($returnTypeAbi);
        }

        // @todo Are complex types are all ready fine?
        // The following would be fine, as implemented here. But not consistently tested yet.
        // $block = $this->eth->eth_getBlockByHash(new EthD32('0x36999a8cecbb02a83e4ff0b233a76063d9db5258340389e24c80f22752ab108b'), new EthB(TRUE));

        return $return;
    }

    /**
     * @param $m
     *    Method as returned from self::getMethod()
     * @return string
     *    Function signature. E.g: multiply(uint256).
     */
    private static function getMethodSignature($m)
    {
        $sign = $m->name . '(';
        foreach ($m->inputs as $i => $item) {
            $sign .= $item->type;
            if ($i < count($m->inputs) - 1) {
                $sign .= ',';
            }
        }
        $sign .= ')';
        return EthereumStatic::getMethodSignature($sign);
    }


    /**
     * @param $m
     * @param $values
     * @return string
     */
    private static function getMethodParams($m, $values)
    {
        $params = '';
        foreach ($values as $i => $val) {
            $params .= EthereumStatic::removeHexPrefix($val->hexVal());
        }
        return $params;
    }


    /**
     * @param $methodName string
     *    Name of Method.
     * @return Object
     *    ABI Object
     * @throws Exception
     *    If called method is not defined in ABI.
     */
    private function getMethod($methodName)
    {
        return $this->getMethodFromAbi($methodName, $this->abi);
    }

    /**
     * @param $methodName
     * @param $abi
     * @return mixed
     * @throws Exception
     *  If method does not exist.
     */
    public static function getMethodFromAbi($methodName, $abi){

        foreach ($abi as $item) {

            if (isset($item->name)
                && isset($item->type)
                && $item->type === 'function'
                && $item->name === $methodName
            ) {
                return $item;
            }
        }
        throw new \Exception('Called undefined contract method: ' . $methodName);
    }
}
