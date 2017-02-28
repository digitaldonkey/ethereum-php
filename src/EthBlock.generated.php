<?php

namespace Ethereum;

/**
 * Implement data type Block.
 */
class Block extends EthDataType {

  protected $number;
  protected $hash;
  protected $parentHash;
  protected $nonce;
  protected $sha3Uncles;
  protected $logsBloom;
  protected $transactionsRoot;
  protected $stateRoot;
  protected $receiptsRoot;
  protected $miner;
  protected $difficulty;
  protected $totalDifficulty;
  protected $extraData;
  protected $size;
  protected $gasLimit;
  protected $gasUsed;
  protected $timestamp;
  protected $transactions;
  protected $uncles;

  /**
   * Constructor.
   */
  public function __construct(EthQ $number = NULL, EthD32 $hash = NULL, EthD32 $parentHash = NULL, EthD $nonce = NULL, EthD $sha3Uncles = NULL, EthD $logsBloom = NULL, EthD $transactionsRoot = NULL, EthD $stateRoot = NULL, EthD $receiptsRoot = NULL, EthD $miner = NULL, EthQ $difficulty = NULL, EthQ $totalDifficulty = NULL, EthD $extraData = NULL, EthQ $size = NULL, EthQ $gasLimit = NULL, EthQ $gasUsed = NULL, EthQ $timestamp = NULL, Array  $transactions = NULL, Array  $uncles = NULL) {
    $this->number = $number;  
    $this->hash = $hash;  
    $this->parentHash = $parentHash;  
    $this->nonce = $nonce;  
    $this->sha3Uncles = $sha3Uncles;  
    $this->logsBloom = $logsBloom;  
    $this->transactionsRoot = $transactionsRoot;  
    $this->stateRoot = $stateRoot;  
    $this->receiptsRoot = $receiptsRoot;  
    $this->miner = $miner;  
    $this->difficulty = $difficulty;  
    $this->totalDifficulty = $totalDifficulty;  
    $this->extraData = $extraData;  
    $this->size = $size;  
    $this->gasLimit = $gasLimit;  
    $this->gasUsed = $gasUsed;  
    $this->timestamp = $timestamp;  
    $this->transactions = $transactions;  
    $this->uncles = $uncles; 
  }

    public function setNumber(EthQ $value){
      $this->number = $value;
    }
    public function setHash(EthD32 $value){
      $this->hash = $value;
    }
    public function setParentHash(EthD32 $value){
      $this->parentHash = $value;
    }
    public function setNonce(EthD $value){
      $this->nonce = $value;
    }
    public function setSha3Uncles(EthD $value){
      $this->sha3Uncles = $value;
    }
    public function setLogsBloom(EthD $value){
      $this->logsBloom = $value;
    }
    public function setTransactionsRoot(EthD $value){
      $this->transactionsRoot = $value;
    }
    public function setStateRoot(EthD $value){
      $this->stateRoot = $value;
    }
    public function setReceiptsRoot(EthD $value){
      $this->receiptsRoot = $value;
    }
    public function setMiner(EthD $value){
      $this->miner = $value;
    }
    public function setDifficulty(EthQ $value){
      $this->difficulty = $value;
    }
    public function setTotalDifficulty(EthQ $value){
      $this->totalDifficulty = $value;
    }
    public function setExtraData(EthD $value){
      $this->extraData = $value;
    }
    public function setSize(EthQ $value){
      $this->size = $value;
    }
    public function setGasLimit(EthQ $value){
      $this->gasLimit = $value;
    }
    public function setGasUsed(EthQ $value){
      $this->gasUsed = $value;
    }
    public function setTimestamp(EthQ $value){
      $this->timestamp = $value;
    }
    public function setTransactions( $value){
      $this->transactions = $value;
    }
    public function setUncles( $value){
      $this->uncles = $value;
    }


  public function toArray() {
    $return = array();
      (!is_null($this->number)) ? $return['number'] = $this->number->getHexVal() : NULL; 
      (!is_null($this->hash)) ? $return['hash'] = $this->hash->getHexVal() : NULL; 
      (!is_null($this->parentHash)) ? $return['parentHash'] = $this->parentHash->getHexVal() : NULL; 
      (!is_null($this->nonce)) ? $return['nonce'] = $this->nonce->getHexVal() : NULL; 
      (!is_null($this->sha3Uncles)) ? $return['sha3Uncles'] = $this->sha3Uncles->getHexVal() : NULL; 
      (!is_null($this->logsBloom)) ? $return['logsBloom'] = $this->logsBloom->getHexVal() : NULL; 
      (!is_null($this->transactionsRoot)) ? $return['transactionsRoot'] = $this->transactionsRoot->getHexVal() : NULL; 
      (!is_null($this->stateRoot)) ? $return['stateRoot'] = $this->stateRoot->getHexVal() : NULL; 
      (!is_null($this->receiptsRoot)) ? $return['receiptsRoot'] = $this->receiptsRoot->getHexVal() : NULL; 
      (!is_null($this->miner)) ? $return['miner'] = $this->miner->getHexVal() : NULL; 
      (!is_null($this->difficulty)) ? $return['difficulty'] = $this->difficulty->getHexVal() : NULL; 
      (!is_null($this->totalDifficulty)) ? $return['totalDifficulty'] = $this->totalDifficulty->getHexVal() : NULL; 
      (!is_null($this->extraData)) ? $return['extraData'] = $this->extraData->getHexVal() : NULL; 
      (!is_null($this->size)) ? $return['size'] = $this->size->getHexVal() : NULL; 
      (!is_null($this->gasLimit)) ? $return['gasLimit'] = $this->gasLimit->getHexVal() : NULL; 
      (!is_null($this->gasUsed)) ? $return['gasUsed'] = $this->gasUsed->getHexVal() : NULL; 
      (!is_null($this->timestamp)) ? $return['timestamp'] = $this->timestamp->getHexVal() : NULL; 
      (!is_null($this->transactions)) ? $return['transactions'] = $this->transactions->getHexVal() : NULL; 
      (!is_null($this->uncles)) ? $return['uncles'] = $this->uncles->getHexVal() : NULL; 
    return $return;
  }
}