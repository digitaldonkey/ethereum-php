<?php

namespace Ethereum;

/**
 * Implement data type Transaction.
 */
class Transaction extends EthDataType {

  protected $hash;
  protected $nonce;
  protected $blockHash;
  protected $blockNumber;
  protected $transactionIndex;
  protected $from;
  protected $to;
  protected $value;
  protected $gasPrice;
  protected $gas;
  protected $input;

  /**
   * Constructor.
   */
  public function __construct(EthD32 $hash = NULL, EthQ $nonce = NULL, EthD32 $blockHash = NULL, EthQ $blockNumber = NULL, EthQ $transactionIndex = NULL, EthD20 $from = NULL, EthD20 $to = NULL, EthQ $value = NULL, EthQ $gasPrice = NULL, EthQ $gas = NULL, EthD $input = NULL) {
    $this->hash = $hash;  
    $this->nonce = $nonce;  
    $this->blockHash = $blockHash;  
    $this->blockNumber = $blockNumber;  
    $this->transactionIndex = $transactionIndex;  
    $this->from = $from;  
    $this->to = $to;  
    $this->value = $value;  
    $this->gasPrice = $gasPrice;  
    $this->gas = $gas;  
    $this->input = $input; 
  }

    public function setHash(EthD32 $value){
      $this->hash = $value;
    }
    public function setNonce(EthQ $value){
      $this->nonce = $value;
    }
    public function setBlockHash(EthD32 $value){
      $this->blockHash = $value;
    }
    public function setBlockNumber(EthQ $value){
      $this->blockNumber = $value;
    }
    public function setTransactionIndex(EthQ $value){
      $this->transactionIndex = $value;
    }
    public function setFrom(EthD20 $value){
      $this->from = $value;
    }
    public function setTo(EthD20 $value){
      $this->to = $value;
    }
    public function setValue(EthQ $value){
      $this->value = $value;
    }
    public function setGasPrice(EthQ $value){
      $this->gasPrice = $value;
    }
    public function setGas(EthQ $value){
      $this->gas = $value;
    }
    public function setInput(EthD $value){
      $this->input = $value;
    }


  public function getType() {
    return 'Transaction';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->hash)) ? $return['hash'] = $this->hash->hexVal() : NULL; 
      (!is_null($this->nonce)) ? $return['nonce'] = $this->nonce->hexVal() : NULL; 
      (!is_null($this->blockHash)) ? $return['blockHash'] = $this->blockHash->hexVal() : NULL; 
      (!is_null($this->blockNumber)) ? $return['blockNumber'] = $this->blockNumber->hexVal() : NULL; 
      (!is_null($this->transactionIndex)) ? $return['transactionIndex'] = $this->transactionIndex->hexVal() : NULL; 
      (!is_null($this->from)) ? $return['from'] = $this->from->hexVal() : NULL; 
      (!is_null($this->to)) ? $return['to'] = $this->to->hexVal() : NULL; 
      (!is_null($this->value)) ? $return['value'] = $this->value->hexVal() : NULL; 
      (!is_null($this->gasPrice)) ? $return['gasPrice'] = $this->gasPrice->hexVal() : NULL; 
      (!is_null($this->gas)) ? $return['gas'] = $this->gas->hexVal() : NULL; 
      (!is_null($this->input)) ? $return['input'] = $this->input->hexVal() : NULL; 
    return $return;
  }
}