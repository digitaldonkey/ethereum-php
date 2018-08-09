<?php

namespace Ethereum;
use Ethereum\DataType\FilterChange;
use Ethereum\DataType\Transaction;


class EmittedEvent extends Event
{

    protected $data = null;
    protected $transaction = null;
    protected $contractAddress;
    protected $emitterAddress;

    /**
     * EmittedEvent constructor.
     * @param $eventOrAbi
     * @param \Ethereum\DataType\FilterChange $filterChange
     * @param \Ethereum\DataType\Transaction $tx
     *
     * @throws \Exception
     *   If FilterChange and Transaction don't correspond.
     */
    public function __construct($eventOrAbi, FilterChange $filterChange, Transaction $tx)
    {
        self::validate($filterChange, $tx);

        $abi = $eventOrAbi;
        if (is_a($eventOrAbi, '\Ethereum\Event')) {
            /* @var \Ethereum\Event $eventOrAbi  */
            $abi = $eventOrAbi->getAbi();
        }
        parent::__construct($abi);

        $this->data = $this->decode($filterChange);
        $this->transaction = $tx;
        $this->emitterAddress = $tx->from->hexVal();
        $this->contractAddress = $filterChange->address->hexVal();
    }


    /**
     * @return string
     */
    public function getContract() {
        return $this->contractAddress;
    }


    /**
     * @return string
     */
    public function getEmitter() {
        return $this->emitterAddress;
    }


    /**
     * @return bool
     */
    public function hasData() {
        return is_array($this->data);
    }


    /**
     * @return array|null
     */
    public function getData() {
        return $this->data;
    }


    /**
     * Array of hex values.
     *
     * @return array
     */
    public function getRawData() {
        $return = [];
        foreach ($this->getData() as $val) {
            $return[] = $val->hexVal();
        }
        return $return;
    }


    /**
     * @return \Ethereum\DataType\Transaction
     */
    public function getTransaction() {
        return $this->transaction;
    }


    /**
     * @param \Ethereum\DataType\FilterChange $filterChange
     * @param \Ethereum\DataType\Transaction $tx
     * @throws \Exception
     */
    private static function validate(FilterChange $filterChange, Transaction $tx) {
        if ($filterChange->transactionHash->hexVal() !== $tx->hash->hexVal()) {
            throw new \Exception('FilterChange and Transaction hash must correspond to create a EmittedEvent.');
        }
        if (!isset($tx->from) || is_null($tx->from)) {
            throw new \Exception('Could not determine Event emitter EmittedEvent.');
        }
    }


}
