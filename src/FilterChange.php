<?php

namespace Ethereum;

/**
 * Implement data type FilterChange.
 */
class FilterChange extends EthDataType {

  protected $removed;
  protected $logIndex;
  protected $transactionIndex;
  protected $transactionHash;
  protected $blockHash;
  protected $blockNumber;
  protected $address;
  protected $data;
  protected $topics;

  /**
   * Constructor.
   */
  public function __construct(EthB $removed = NULL, EthQ $logIndex = NULL, EthQ $transactionIndex = NULL, EthD32 $transactionHash = NULL, EthD32 $blockHash = NULL, EthQ $blockNumber = NULL, EthD20 $address = NULL, EthData $data = NULL, array  $topics = NULL) {
    $this->removed = $removed;  
    $this->logIndex = $logIndex;  
    $this->transactionIndex = $transactionIndex;  
    $this->transactionHash = $transactionHash;  
    $this->blockHash = $blockHash;  
    $this->blockNumber = $blockNumber;  
    $this->address = $address;  
    $this->data = $data;  
    $this->topics = $topics; 
  }

  public function setRemoved(EthB $value){
    if (is_object($value) && is_a($value, 'EthB')) {
      $this->removed = $value;
    }
    else {
      $this->removed = new EthB($value);
    }
  }

  public function setLogIndex(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->logIndex = $value;
    }
    else {
      $this->logIndex = new EthQ($value);
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

  public function setTransactionHash(EthD32 $value){
    if (is_object($value) && is_a($value, 'EthD32')) {
      $this->transactionHash = $value;
    }
    else {
      $this->transactionHash = new EthD32($value);
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

  public function setAddress(EthD20 $value){
    if (is_object($value) && is_a($value, 'EthD20')) {
      $this->address = $value;
    }
    else {
      $this->address = new EthD20($value);
    }
  }

  public function setData(EthData $value){
    if (is_object($value) && is_a($value, 'EthData')) {
      $this->data = $value;
    }
    else {
      $this->data = new EthData($value);
    }
  }

  public function setTopics(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->topics = $value;
    }
    else {
      $this->topics = new EthD($value);
    }
  }



  public function getType() {
    return 'FilterChange';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->removed)) ? $return['removed'] = $this->removed->hexVal() : NULL; 
      (!is_null($this->logIndex)) ? $return['logIndex'] = $this->logIndex->hexVal() : NULL; 
      (!is_null($this->transactionIndex)) ? $return['transactionIndex'] = $this->transactionIndex->hexVal() : NULL; 
      (!is_null($this->transactionHash)) ? $return['transactionHash'] = $this->transactionHash->hexVal() : NULL; 
      (!is_null($this->blockHash)) ? $return['blockHash'] = $this->blockHash->hexVal() : NULL; 
      (!is_null($this->blockNumber)) ? $return['blockNumber'] = $this->blockNumber->hexVal() : NULL; 
      (!is_null($this->address)) ? $return['address'] = $this->address->hexVal() : NULL; 
      (!is_null($this->data)) ? $return['data'] = $this->data->hexVal() : NULL; 
      (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : array(); 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'removed' => 'EthB',
      'logIndex' => 'EthQ',
      'transactionIndex' => 'EthQ',
      'transactionHash' => 'EthD32',
      'blockHash' => 'EthD32',
      'blockNumber' => 'EthQ',
      'address' => 'EthD20',
      'data' => 'EthData',
      'topics' => 'EthD',
    );
  }
}