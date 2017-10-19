<?php

namespace Ethereum;

/**
 * Implement data type Filter.
 */
class Filter extends EthDataType
{
    protected $fromBlock;
    protected $toBlock;
    protected $address;
    protected $topics;

    /**
     * Constructor.
     * @param EthBlockParam|null $fromBlock
     * @param EthBlockParam|null $toBlock
     * @param EthData|null       $address
     * @param array|null         $topics
     */
    public function __construct(
        EthBlockParam $fromBlock = null,
        EthBlockParam $toBlock = null,
        EthData $address = null,
        array $topics = null
    ) {
        $this->fromBlock = $fromBlock;
        $this->toBlock = $toBlock;
        $this->address = $address;
        $this->topics = $topics;
    }

    public function setFromBlock(EthBlockParam $value)
    {
        if (is_object($value) && is_a($value, 'EthBlockParam')) {
            $this->fromBlock = $value;
        } else {
            $this->fromBlock = new EthBlockParam($value);
        }
    }

    public function setToBlock(EthBlockParam $value)
    {
        if (is_object($value) && is_a($value, 'EthBlockParam')) {
            $this->toBlock = $value;
        } else {
            $this->toBlock = new EthBlockParam($value);
        }
    }

    public function setAddress(EthData $value)
    {
        if (is_object($value) && is_a($value, 'EthData')) {
            $this->address = $value;
        } else {
            $this->address = new EthData($value);
        }
    }

    public function setTopics(EthD $value)
    {
        if (is_object($value) && is_a($value, 'EthD')) {
            $this->topics = $value;
        } else {
            $this->topics = new EthD($value);
        }
    }

    public function getType()
    {
        return 'Filter';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $return = [];
        (!is_null($this->fromBlock)) ? $return['fromBlock'] = $this->fromBlock->hexVal() : null;
        (!is_null($this->toBlock)) ? $return['toBlock'] = $this->toBlock->hexVal() : null;
        (!is_null($this->address)) ? $return['address'] = $this->address->hexVal() : null;
        (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : [];

        return $return;
    }

    /**
     * Returns a name => type array.
     */
    public static function getTypeArray()
    {
        return [
            'fromBlock' => 'EthBlockParam',
            'toBlock'   => 'EthBlockParam',
            'address'   => 'EthData',
            'topics'    => 'EthD',
        ];
    }
}