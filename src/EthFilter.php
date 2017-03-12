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
  public function __construct(EthBlockParam $fromBlock = NULL, EthBlockParam $toBlock = NULL, EthData $address = NULL, Array  $topics = NULL) {
    $this->fromBlock = $fromBlock;  
    $this->toBlock = $toBlock;  
    $this->address = $address;  
    $this->topics = $topics; 
  }

    public function setFromBlock(EthBlockParam $value){
      $this->fromBlock = $value;
    }
    public function setToBlock(EthBlockParam $value){
      $this->toBlock = $value;
    }
    public function setAddress(EthData $value){
      $this->address = $value;
    }
    public function setTopics( $value){
      $this->topics = $value;
    }


  public function toArray() {
    $return = array();
      (!is_null($this->fromBlock)) ? $return['fromBlock'] = $this->fromBlock->getHexVal() : NULL; 
      (!is_null($this->toBlock)) ? $return['toBlock'] = $this->toBlock->getHexVal() : NULL; 
      (!is_null($this->address)) ? $return['address'] = $this->address->getHexVal() : NULL; 
      (!is_null($this->topics)) ? $return['topics'] = $this->topics->getHexVal() : NULL; 
    return $return;
  }
}