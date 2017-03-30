<?php

namespace Ethereum;

/**
 * Implement data type EthSyncing.
 */
class EthSyncing extends EthDataType {

  protected $startingBlock;
  protected $currentBlock;
  protected $highestBlock;

  /**
   * Constructor.
   */
  public function __construct(EthQ $startingBlock = NULL, EthQ $currentBlock = NULL, EthQ $highestBlock = NULL) {
    $this->startingBlock = $startingBlock;  
    $this->currentBlock = $currentBlock;  
    $this->highestBlock = $highestBlock; 
  }

  public function setStartingBlock(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->startingBlock = $value;
    }
    else {
      $this->startingBlock = new EthQ($value);
    }
  }

  public function setCurrentBlock(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->currentBlock = $value;
    }
    else {
      $this->currentBlock = new EthQ($value);
    }
  }

  public function setHighestBlock(EthQ $value){
    if (is_object($value) && is_a($value, 'EthQ')) {
      $this->highestBlock = $value;
    }
    else {
      $this->highestBlock = new EthQ($value);
    }
  }



  public function getType() {
    return 'EthSyncing';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->startingBlock)) ? $return['startingBlock'] = $this->startingBlock->hexVal() : NULL; 
      (!is_null($this->currentBlock)) ? $return['currentBlock'] = $this->currentBlock->hexVal() : NULL; 
      (!is_null($this->highestBlock)) ? $return['highestBlock'] = $this->highestBlock->hexVal() : NULL; 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'startingBlock' => 'EthQ',
      'currentBlock' => 'EthQ',
      'highestBlock' => 'EthQ',
    );
  }
}