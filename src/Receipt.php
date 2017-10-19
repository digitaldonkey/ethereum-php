<?php

namespace Ethereum;

/**
 * Implement data type Receipt.
 */
class Receipt extends EthDataType
{
    protected $transactionHash;
    protected $transactionIndex;
    protected $blockHash;
    protected $blockNumber;
    protected $cumulativeGasUsed;
    protected $gasUsed;
    protected $contractAddress;
    protected $logs;

    /**
     * Constructor.
     * @param EthD32|null $transactionHash
     * @param EthQ|null   $transactionIndex
     * @param EthD32|null $blockHash
     * @param EthQ|null   $blockNumber
     * @param EthQ|null   $cumulativeGasUsed
     * @param EthQ|null   $gasUsed
     * @param EthD20|null $contractAddress
     * @param array|null  $logs
     */
    public function __construct(
        EthD32 $transactionHash = null,
        EthQ $transactionIndex = null,
        EthD32 $blockHash = null,
        EthQ $blockNumber = null,
        EthQ $cumulativeGasUsed = null,
        EthQ $gasUsed = null,
        EthD20 $contractAddress = null,
        array $logs = null
    ) {
        $this->transactionHash = $transactionHash;
        $this->transactionIndex = $transactionIndex;
        $this->blockHash = $blockHash;
        $this->blockNumber = $blockNumber;
        $this->cumulativeGasUsed = $cumulativeGasUsed;
        $this->gasUsed = $gasUsed;
        $this->contractAddress = $contractAddress;
        $this->logs = $logs;
    }

    public function setTransactionHash(EthD32 $value)
    {
        if (is_object($value) && is_a($value, 'EthD32')) {
            $this->transactionHash = $value;
        } else {
            $this->transactionHash = new EthD32($value);
        }
    }

    public function setTransactionIndex(EthQ $value)
    {
        if (is_object($value) && is_a($value, 'EthQ')) {
            $this->transactionIndex = $value;
        } else {
            $this->transactionIndex = new EthQ($value);
        }
    }

    public function setBlockHash(EthD32 $value)
    {
        if (is_object($value) && is_a($value, 'EthD32')) {
            $this->blockHash = $value;
        } else {
            $this->blockHash = new EthD32($value);
        }
    }

    public function setBlockNumber(EthQ $value)
    {
        if (is_object($value) && is_a($value, 'EthQ')) {
            $this->blockNumber = $value;
        } else {
            $this->blockNumber = new EthQ($value);
        }
    }

    public function setCumulativeGasUsed(EthQ $value)
    {
        if (is_object($value) && is_a($value, 'EthQ')) {
            $this->cumulativeGasUsed = $value;
        } else {
            $this->cumulativeGasUsed = new EthQ($value);
        }
    }

    public function setGasUsed(EthQ $value)
    {
        if (is_object($value) && is_a($value, 'EthQ')) {
            $this->gasUsed = $value;
        } else {
            $this->gasUsed = new EthQ($value);
        }
    }

    public function setContractAddress(EthD20 $value)
    {
        if (is_object($value) && is_a($value, 'EthD20')) {
            $this->contractAddress = $value;
        } else {
            $this->contractAddress = new EthD20($value);
        }
    }

    public function setLogs(Array $value)
    {
        if (is_object($value) && is_a($value, 'Array')) {
            $this->logs = $value;
        } else {
            $this->logs = new [$value];
        }
    }


    public function getType()
    {
        return 'Receipt';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $return = [];
        (!is_null($this->transactionHash)) ? $return['transactionHash'] = $this->transactionHash->hexVal() : null;
        (!is_null($this->transactionIndex)) ? $return['transactionIndex'] = $this->transactionIndex->hexVal() : null;
        (!is_null($this->blockHash)) ? $return['blockHash'] = $this->blockHash->hexVal() : null;
        (!is_null($this->blockNumber)) ? $return['blockNumber'] = $this->blockNumber->hexVal() : null;
        (!is_null($this->cumulativeGasUsed)) ? $return['cumulativeGasUsed'] = $this->cumulativeGasUsed->hexVal() : null;
        (!is_null($this->gasUsed)) ? $return['gasUsed'] = $this->gasUsed->hexVal() : null;
        (!is_null($this->contractAddress)) ? $return['contractAddress'] = $this->contractAddress->hexVal() : null;
        (!is_null($this->logs)) ? $return['logs'] = EthereumStatic::valueArray($this->logs, 'FilterChange') : [];

        return $return;
    }

    /**
     * Returns a name => type array.
     */
    public static function getTypeArray()
    {
        return [
            'transactionHash'   => 'EthD32',
            'transactionIndex'  => 'EthQ',
            'blockHash'         => 'EthD32',
            'blockNumber'       => 'EthQ',
            'cumulativeGasUsed' => 'EthQ',
            'gasUsed'           => 'EthQ',
            'contractAddress'   => 'EthD20',
            'logs'              => '',
        ];
    }
}