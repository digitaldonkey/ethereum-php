<?php

namespace Ethereum;

/**
 * Implement data type SHHPost.
 */
class SHHPost extends EthDataType {

  protected $topics;
  protected $payload;
  protected $priority;
  protected $ttl;
  protected $from;
  protected $to;

  /**
   * Constructor.
   */
  public function __construct(Array  $topics, EthD $payload, EthQ $priority, EthQ $ttl, EthD $from = NULL, EthD $to = NULL) {
    $this->topics = $topics;  
    $this->payload = $payload;  
    $this->priority = $priority;  
    $this->ttl = $ttl;  
    $this->from = $from;  
    $this->to = $to; 
  }

  public function setTopics(EthD $value){
    $this->topics = $value;
  }

  public function setPayload(EthD $value){
    $this->payload = $value;
  }

  public function setPriority(EthQ $value){
    $this->priority = $value;
  }

  public function setTtl(EthQ $value){
    $this->ttl = $value;
  }

  public function setFrom(EthD $value){
    $this->from = $value;
  }

  public function setTo(EthD $value){
    $this->to = $value;
  }



  public function getType() {
    return 'SHHPost';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : array(); 
      (!is_null($this->payload)) ? $return['payload'] = $this->payload->hexVal() : NULL; 
      (!is_null($this->priority)) ? $return['priority'] = $this->priority->hexVal() : NULL; 
      (!is_null($this->ttl)) ? $return['ttl'] = $this->ttl->hexVal() : NULL; 
      (!is_null($this->from)) ? $return['from'] = $this->from->hexVal() : NULL; 
      (!is_null($this->to)) ? $return['to'] = $this->to->hexVal() : NULL; 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'topics' => 'EthD',
      'payload' => 'EthD',
      'priority' => 'EthQ',
      'ttl' => 'EthQ',
      'from' => 'EthD',
      'to' => 'EthD',
    );
  }
}