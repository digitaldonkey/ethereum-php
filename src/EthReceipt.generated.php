<?php

namespace Ethereum;

/**
 * Implement data type Receipt.
 */
class Receipt extends EthDataType {

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
   */
  public function __construct(EthD32 $transactionHash = NULL, EthQ $transactionIndex = NULL, EthD32 $blockHash = NULL, EthQ $blockNumber = NULL, EthQ $cumulativeGasUsed = NULL, EthQ $gasUsed = NULL, EthD20 $contractAddress = NULL, Array  $logs = NULL) {
    $this->transactionHash = $transactionHash;  
    $this->transactionIndex = $transactionIndex;  
    $this->blockHash = $blockHash;  
    $this->blockNumber = $blockNumber;  
    $this->cumulativeGasUsed = $cumulativeGasUsed;  
    $this->gasUsed = $gasUsed;  
    $this->contractAddress = $contractAddress;  
    $this->logs = $logs; 
  }

    public function setTransactionHash(EthD32 $value){
      $this->transactionHash = $value;
    }
    public function setTransactionIndex(EthQ $value){
      $this->transactionIndex = $value;
    }
    public function setBlockHash(EthD32 $value){
      $this->blockHash = $value;
    }
    public function setBlockNumber(EthQ $value){
      $this->blockNumber = $value;
    }
    public function setCumulativeGasUsed(EthQ $value){
      $this->cumulativeGasUsed = $value;
    }
    public function setGasUsed(EthQ $value){
      $this->gasUsed = $value;
    }
    public function setContractAddress(EthD20 $value){
      $this->contractAddress = $value;
    }
    public function setLogs( $value){
      $this->logs = $value;
    }


  public function toArray() {
    $return = array();
      (!is_null($this->transactionHash)) ? $return['transactionHash'] = $this->transactionHash->getHexVal() : NULL; 
      (!is_null($this->transactionIndex)) ? $return['transactionIndex'] = $this->transactionIndex->getHexVal() : NULL; 
      (!is_null($this->blockHash)) ? $return['blockHash'] = $this->blockHash->getHexVal() : NULL; 
      (!is_null($this->blockNumber)) ? $return['blockNumber'] = $this->blockNumber->getHexVal() : NULL; 
      (!is_null($this->cumulativeGasUsed)) ? $return['cumulativeGasUsed'] = $this->cumulativeGasUsed->getHexVal() : NULL; 
      (!is_null($this->gasUsed)) ? $return['gasUsed'] = $this->gasUsed->getHexVal() : NULL; 
      (!is_null($this->contractAddress)) ? $return['contractAddress'] = $this->contractAddress->getHexVal() : NULL; 
      (!is_null($this->logs)) ? $return['logs'] = $this->logs->getHexVal() : NULL; 
    return $return;
  }
}