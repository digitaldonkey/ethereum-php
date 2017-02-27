<?php

class EthSyncing extends EthDataType {

  protected $startingBlock;
  protected $currentBlock;
  protected $highestBlock;


  public function __construct(EthQ $startingBlock = NULL, EthQ $currentBlock = NULL, EthQ $highestBlock = NULL) {
    $this->startingBlock = $startingBlock;  
    $this->currentBlock = $currentBlock;  
    $this->highestBlock = $highestBlock; 
  }

    public function setStartingBlock(EthQ $value){
      $this->startingBlock = $value;
    }
    public function setCurrentBlock(EthQ $value){
      $this->currentBlock = $value;
    }
    public function setHighestBlock(EthQ $value){
      $this->highestBlock = $value;
    }


  public function toArray() {
    $return = array();
      (!is_null($this->startingBlock)) ? $return['startingBlock'] = $this->startingBlock->getHexVal() : NULL; 
      (!is_null($this->currentBlock)) ? $return['currentBlock'] = $this->currentBlock->getHexVal() : NULL; 
      (!is_null($this->highestBlock)) ? $return['highestBlock'] = $this->highestBlock->getHexVal() : NULL; 
    return $return;
  }
}