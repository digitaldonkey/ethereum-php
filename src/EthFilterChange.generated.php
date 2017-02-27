<?php

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


  public function __construct(EthB $removed = NULL, EthQ $logIndex = NULL, EthQ $transactionIndex = NULL, EthD32 $transactionHash = NULL, EthD32 $blockHash = NULL, EthQ $blockNumber = NULL, EthD20 $address = NULL, EthData $data = NULL, Array  $topics = NULL) {
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
      $this->removed = $value;
    }
    public function setLogIndex(EthQ $value){
      $this->logIndex = $value;
    }
    public function setTransactionIndex(EthQ $value){
      $this->transactionIndex = $value;
    }
    public function setTransactionHash(EthD32 $value){
      $this->transactionHash = $value;
    }
    public function setBlockHash(EthD32 $value){
      $this->blockHash = $value;
    }
    public function setBlockNumber(EthQ $value){
      $this->blockNumber = $value;
    }
    public function setAddress(EthD20 $value){
      $this->address = $value;
    }
    public function setData(EthData $value){
      $this->data = $value;
    }
    public function setTopics( $value){
      $this->topics = $value;
    }


  public function toArray() {
    $return = array();
      (!is_null($this->removed)) ? $return['removed'] = $this->removed->getHexVal() : NULL; 
      (!is_null($this->logIndex)) ? $return['logIndex'] = $this->logIndex->getHexVal() : NULL; 
      (!is_null($this->transactionIndex)) ? $return['transactionIndex'] = $this->transactionIndex->getHexVal() : NULL; 
      (!is_null($this->transactionHash)) ? $return['transactionHash'] = $this->transactionHash->getHexVal() : NULL; 
      (!is_null($this->blockHash)) ? $return['blockHash'] = $this->blockHash->getHexVal() : NULL; 
      (!is_null($this->blockNumber)) ? $return['blockNumber'] = $this->blockNumber->getHexVal() : NULL; 
      (!is_null($this->address)) ? $return['address'] = $this->address->getHexVal() : NULL; 
      (!is_null($this->data)) ? $return['data'] = $this->data->getHexVal() : NULL; 
      (!is_null($this->topics)) ? $return['topics'] = $this->topics->getHexVal() : NULL; 
    return $return;
  }
}