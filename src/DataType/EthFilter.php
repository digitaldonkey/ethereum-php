<?php

namespace Ethereum\DataType;

/**
 * Implement data type Filter.
 */
class EthFilter extends EthDataType
{
    protected $fromBlock;
    protected $toBlock;
    protected $address;
    protected $topics;

    /**
     * Constructor.
     * @param EthBlockParam|null $fromBlock
     * @param EthBlockParam|null $toBlock
     * @param EthBytes|null       $address
     * @param array|null         $topics
     */
    public function __construct(
        EthBlockParam $fromBlock = null,
        EthBlockParam $toBlock = null,
        EthBytes $address = null,
        Array $topics = null
    ) {
        $this->fromBlock = $fromBlock;
        $this->toBlock = $toBlock;
        $this->address = $address;
        $this->topics = $topics;
    }

    public function setFromBlock(EthBlockParam $value)
    {
        $this->fromBlock = $value;
    }

    public function setToBlock(EthBlockParam $value)
    {
        $this->toBlock = $value;
    }

    public function setAddress(EthBytes $value)
    {
        $this->address = $value;
    }

    public function setTopics($value)
    {
        $this->topics = $value;
    }

    /**
     * @return array
     * @throw Exception
     */
    public function toArray()
    {
        $return = [];
        (!is_null($this->fromBlock)) ? $return['fromBlock'] = $this->fromBlock->getHexVal() : null;
        (!is_null($this->toBlock)) ? $return['toBlock'] = $this->toBlock->getHexVal() : null;
        (!is_null($this->address)) ? $return['address'] = $this->address->getHexVal() : null;
        (!is_null($this->topics)) ? $return['topics'] = $this->topics->getHexVal() : null;

        return $return;
    }
}
