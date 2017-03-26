<?php

namespace Ethereum;

/**
 * Implement data type SHHFilterChange.
 */
class SHHFilterChange extends EthDataType {

  protected $hash;
  protected $from;
  protected $to;
  protected $expiry;
  protected $ttl;
  protected $sent;
  protected $topics;
  protected $payload;
  protected $workProved;

  /**
   * Constructor.
   */
  public function __construct(EthD $hash = NULL, EthD $from = NULL, EthD $to = NULL, EthQ $expiry = NULL, EthQ $ttl = NULL, EthQ $sent = NULL, Array  $topics = NULL, EthD $payload = NULL, EthQ $workProved = NULL) {
    $this->hash = $hash;  
    $this->from = $from;  
    $this->to = $to;  
    $this->expiry = $expiry;  
    $this->ttl = $ttl;  
    $this->sent = $sent;  
    $this->topics = $topics;  
    $this->payload = $payload;  
    $this->workProved = $workProved; 
  }

  public function setHash(EthD $value){
    $this->hash = $value;
  }

  public function setFrom(EthD $value){
    $this->from = $value;
  }

  public function setTo(EthD $value){
    $this->to = $value;
  }

  public function setExpiry(EthQ $value){
    $this->expiry = $value;
  }

  public function setTtl(EthQ $value){
    $this->ttl = $value;
  }

  public function setSent(EthQ $value){
    $this->sent = $value;
  }

  public function setTopics(EthD $value){
    $this->topics = $value;
  }

  public function setPayload(EthD $value){
    $this->payload = $value;
  }

  public function setWorkProved(EthQ $value){
    $this->workProved = $value;
  }



  public function getType() {
    return 'SHHFilterChange';
  }

  public function toArray() {
    $return = array();
      (!is_null($this->hash)) ? $return['hash'] = $this->hash->hexVal() : NULL; 
      (!is_null($this->from)) ? $return['from'] = $this->from->hexVal() : NULL; 
      (!is_null($this->to)) ? $return['to'] = $this->to->hexVal() : NULL; 
      (!is_null($this->expiry)) ? $return['expiry'] = $this->expiry->hexVal() : NULL; 
      (!is_null($this->ttl)) ? $return['ttl'] = $this->ttl->hexVal() : NULL; 
      (!is_null($this->sent)) ? $return['sent'] = $this->sent->hexVal() : NULL; 
      (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : array(); 
      (!is_null($this->payload)) ? $return['payload'] = $this->payload->hexVal() : NULL; 
      (!is_null($this->workProved)) ? $return['workProved'] = $this->workProved->hexVal() : NULL; 
    return $return;
  }
 /**
  * Returns a name => type array.
  */
  public static function getTypeArray() {
    return array( 
      'hash' => 'EthD',
      'from' => 'EthD',
      'to' => 'EthD',
      'expiry' => 'EthQ',
      'ttl' => 'EthQ',
      'sent' => 'EthQ',
      'topics' => 'EthD',
      'payload' => 'EthD',
      'workProved' => 'EthQ',
    );
  }
}