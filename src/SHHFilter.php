<?php

namespace Ethereum;

/**
 * Implement data type SHHFilter.
 */
class SHHFilter extends EthDataType {

  protected $topics;
  protected $to;

  /**
   * Constructor.
   */
  public function __construct(array  $topics, EthD $to = NULL) {
    $this->topics = $topics;  
    $this->to = $to; 
  }

  public function setTopics(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->topics = $value;
    }
    else {
      $this->topics = new EthD($value);
    }
  }

  public function setTo(EthD $value){
    if (is_object($value) && is_a($value, 'EthD')) {
      $this->to = $value;
    }
    else {
      $this->to = new EthD($value);
    }
  }



  public function getType() {
    return 'SHHFilter';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : array(); 
      (!is_null($this->to)) ? $return['to'] = $this->to->hexVal() : NULL; 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'topics' => 'EthD',
      'to' => 'EthD',
    );
  }
}