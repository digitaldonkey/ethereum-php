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
    if (is_object($value) && is_a($value, 'EthD32')) {
      $this->hash = $value;
    }
    else {
      $this->hash = new EthD32($value);
    }
  }

  public function setNonce(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->nonce = $value;
    }
    else {
      $this->nonce = new EthQ($value);
    }
  }

  public function setBlockHash(EthD32 $value){
    if (is_object($value) && is_a($value, 'EthD32')) {
      $this->blockHash = $value;
    }
    else {
      $this->blockHash = new EthD32($value);
    }
  }

  public function setBlockNumber(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->blockNumber = $value;
    }
    else {
      $this->blockNumber = new EthQ($value);
    }
  }

  public function setTransactionIndex(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->transactionIndex = $value;
    }
    else {
      $this->transactionIndex = new EthQ($value);
    }
  }

  public function setFrom(EthD20 $value){
    if (is_object($value) && is_a($value, 'EthD20')) {
      $this->from = $value;
    }
    else {
      $this->from = new EthD20($value);
    }
  }

  public function setTo(EthD20 $value){
    if (is_object($value) && is_a($value, 'EthD20')) {
      $this->to = $value;
    }
    else {
      $this->to = new EthD20($value);
    }
  }

  public function setValue(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->value = $value;
    }
    else {
      $this->value = new EthQ($value);
    }
  }

  public function setGasPrice(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->gasPrice = $value;
    }
    else {
      $this->gasPrice = new EthQ($value);
    }
  }

  public function setGas(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->gas = $value;
    }
    else {
      $this->gas = new EthQ($value);
    }
  }

  public function setInput(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->input = $value;
    }
    else {
      $this->input = new EthD($value);
    }
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
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'hash' => 'EthD32',
      'nonce' => 'EthQ',
      'blockHash' => 'EthD32',
      'blockNumber' => 'EthQ',
      'transactionIndex' => 'EthQ',
      'from' => 'EthD20',
      'to' => 'EthD20',
      'value' => 'EthQ',
      'gasPrice' => 'EthQ',
      'gas' => 'EthQ',
      'input' => 'EthD',
    );
  }
}