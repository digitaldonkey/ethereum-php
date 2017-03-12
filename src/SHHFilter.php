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
  public function __construct(Array  $topics, EthD $to = NULL) {
    $this->topics = $topics;  
    $this->to = $to; 
  }

    public function setTopics( $value){
      $this->topics = $value;
    }
    public function setTo(EthD $value){
      $this->to = $value;
    }


  public function getType() {
    return 'SHHFilter';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->topics)) ? $return['topics'] = $this->topics->hexVal() : NULL; 
      (!is_null($this->to)) ? $return['to'] = $this->to->hexVal() : NULL; 
    return $return;
  }
}