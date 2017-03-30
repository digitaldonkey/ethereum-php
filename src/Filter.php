<?php

namespace Ethereum;

/**
 * Implement data type Filter.
 */
class Filter extends EthDataType {

  protected $fromBlock;
  protected $toBlock;
  protected $address;
  protected $topics;

  /**
   * Constructor.
   */
  public function __construct(EthBlockParam $fromBlock = NULL, EthBlockParam $toBlock = NULL, EthData $address = NULL, array  $topics = NULL) {
    $this->fromBlock = $fromBlock;  
    $this->toBlock = $toBlock;  
    $this->address = $address;  
    $this->topics = $topics; 
  }

  public function setFromBlock(EthBlockParam $value){
    if (is_object($value) && is_a($value, 'EthBlockParam')) {
      $this->fromBlock = $value;
    }
    else {
      $this->fromBlock = new EthBlockParam($value);
    }
  }

  public function setToBlock(EthBlockParam $value){
    if (is_object($value) && is_a($value, 'EthBlockParam')) {
      $this->toBlock = $value;
    }
    else {
      $this->toBlock = new EthBlockParam($value);
    }
  }

  public function setAddress(EthData $value){
    if (is_object($value) && is_a($value, 'EthData')) {
      $this->address = $value;
    }
    else {
      $this->address = new EthData($value);
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
    return 'Filter';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->fromBlock)) ? $return['fromBlock'] = $this->fromBlock->hexVal() : NULL; 
      (!is_null($this->toBlock)) ? $return['toBlock'] = $this->toBlock->hexVal() : NULL; 
      (!is_null($this->address)) ? $return['address'] = $this->address->hexVal() : NULL; 
      (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : array(); 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'fromBlock' => 'EthBlockParam',
      'toBlock' => 'EthBlockParam',
      'address' => 'EthData',
      'topics' => 'EthD',
    );
  }
}