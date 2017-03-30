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
  public function __construct(EthQ $number = NULL, EthD32 $hash = NULL, EthD32 $parentHash = NULL, EthD $nonce = NULL, EthD $sha3Uncles = NULL, EthD $logsBloom = NULL, EthD $transactionsRoot = NULL, EthD $stateRoot = NULL, EthD $receiptsRoot = NULL, EthD $miner = NULL, EthQ $difficulty = NULL, EthQ $totalDifficulty = NULL, EthD $extraData = NULL, EthQ $size = NULL, EthQ $gasLimit = NULL, EthQ $gasUsed = NULL, EthQ $timestamp = NULL, array  $transactions = NULL, array  $uncles = NULL) {
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
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->number = $value;
    }
    else {
      $this->number = new EthQ($value);
    }
  }

  public function setHash(EthD32 $value){
    if (is_object($value) && is_a($value, 'EthD32')) {
      $this->hash = $value;
    }
    else {
      $this->hash = new EthD32($value);
    }
  }

  public function setParentHash(EthD32 $value){
    if (is_object($value) && is_a($value, 'EthD32')) {
      $this->parentHash = $value;
    }
    else {
      $this->parentHash = new EthD32($value);
    }
  }

  public function setNonce(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->nonce = $value;
    }
    else {
      $this->nonce = new EthD($value);
    }
  }

  public function setSha3Uncles(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->sha3Uncles = $value;
    }
    else {
      $this->sha3Uncles = new EthD($value);
    }
  }

  public function setLogsBloom(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->logsBloom = $value;
    }
    else {
      $this->logsBloom = new EthD($value);
    }
  }

  public function setTransactionsRoot(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->transactionsRoot = $value;
    }
    else {
      $this->transactionsRoot = new EthD($value);
    }
  }

  public function setStateRoot(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->stateRoot = $value;
    }
    else {
      $this->stateRoot = new EthD($value);
    }
  }

  public function setReceiptsRoot(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->receiptsRoot = $value;
    }
    else {
      $this->receiptsRoot = new EthD($value);
    }
  }

  public function setMiner(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->miner = $value;
    }
    else {
      $this->miner = new EthD($value);
    }
  }

  public function setDifficulty(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->difficulty = $value;
    }
    else {
      $this->difficulty = new EthQ($value);
    }
  }

  public function setTotalDifficulty(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->totalDifficulty = $value;
    }
    else {
      $this->totalDifficulty = new EthQ($value);
    }
  }

  public function setExtraData(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->extraData = $value;
    }
    else {
      $this->extraData = new EthD($value);
    }
  }

  public function setSize(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->size = $value;
    }
    else {
      $this->size = new EthQ($value);
    }
  }

  public function setGasLimit(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->gasLimit = $value;
    }
    else {
      $this->gasLimit = new EthQ($value);
    }
  }

  public function setGasUsed(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->gasUsed = $value;
    }
    else {
      $this->gasUsed = new EthQ($value);
    }
  }

  public function setTimestamp(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->timestamp = $value;
    }
    else {
      $this->timestamp = new EthQ($value);
    }
  }

  public function setTransactions(Transaction $value){
    if (is_object($value) && is_a($value, 'Transaction')) {
      $this->transactions = $value;
    }
    else {
      $this->transactions = new Transaction($value);
    }
  }

  public function setUncles(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->uncles = $value;
    }
    else {
      $this->uncles = new EthD($value);
    }
  }



  public function getType() {
    return 'Block';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->number)) ? $return['number'] = $this->number->hexVal() : NULL; 
      (!is_null($this->hash)) ? $return['hash'] = $this->hash->hexVal() : NULL; 
      (!is_null($this->parentHash)) ? $return['parentHash'] = $this->parentHash->hexVal() : NULL; 
      (!is_null($this->nonce)) ? $return['nonce'] = $this->nonce->hexVal() : NULL; 
      (!is_null($this->sha3Uncles)) ? $return['sha3Uncles'] = $this->sha3Uncles->hexVal() : NULL; 
      (!is_null($this->logsBloom)) ? $return['logsBloom'] = $this->logsBloom->hexVal() : NULL; 
      (!is_null($this->transactionsRoot)) ? $return['transactionsRoot'] = $this->transactionsRoot->hexVal() : NULL; 
      (!is_null($this->stateRoot)) ? $return['stateRoot'] = $this->stateRoot->hexVal() : NULL; 
      (!is_null($this->receiptsRoot)) ? $return['receiptsRoot'] = $this->receiptsRoot->hexVal() : NULL; 
      (!is_null($this->miner)) ? $return['miner'] = $this->miner->hexVal() : NULL; 
      (!is_null($this->difficulty)) ? $return['difficulty'] = $this->difficulty->hexVal() : NULL; 
      (!is_null($this->totalDifficulty)) ? $return['totalDifficulty'] = $this->totalDifficulty->hexVal() : NULL; 
      (!is_null($this->extraData)) ? $return['extraData'] = $this->extraData->hexVal() : NULL; 
      (!is_null($this->size)) ? $return['size'] = $this->size->hexVal() : NULL; 
      (!is_null($this->gasLimit)) ? $return['gasLimit'] = $this->gasLimit->hexVal() : NULL; 
      (!is_null($this->gasUsed)) ? $return['gasUsed'] = $this->gasUsed->hexVal() : NULL; 
      (!is_null($this->timestamp)) ? $return['timestamp'] = $this->timestamp->hexVal() : NULL; 
      (!is_null($this->transactions)) ? $return['transactions'] = EthereumStatic::valueArray($this->transactions, 'DATA|Transaction') : array(); 
      (!is_null($this->uncles)) ? $return['uncles'] = EthereumStatic::valueArray($this->uncles, 'D') : array(); 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'number' => 'EthQ',
      'hash' => 'EthD32',
      'parentHash' => 'EthD32',
      'nonce' => 'EthD',
      'sha3Uncles' => 'EthD',
      'logsBloom' => 'EthD',
      'transactionsRoot' => 'EthD',
      'stateRoot' => 'EthD',
      'receiptsRoot' => 'EthD',
      'miner' => 'EthD',
      'difficulty' => 'EthQ',
      'totalDifficulty' => 'EthQ',
      'extraData' => 'EthD',
      'size' => 'EthQ',
      'gasLimit' => 'EthQ',
      'gasUsed' => 'EthQ',
      'timestamp' => 'EthQ',
      'transactions' => 'Transaction',
      'uncles' => 'EthD',
    );
  }
}