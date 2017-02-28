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
    public function setTopics( $value){
      $this->topics = $value;
    }
    public function setPayload(EthD $value){
      $this->payload = $value;
    }
    public function setWorkProved(EthQ $value){
      $this->workProved = $value;
    }


  public function toArray() {
    $return = array();
      (!is_null($this->hash)) ? $return['hash'] = $this->hash->getHexVal() : NULL; 
      (!is_null($this->from)) ? $return['from'] = $this->from->getHexVal() : NULL; 
      (!is_null($this->to)) ? $return['to'] = $this->to->getHexVal() : NULL; 
      (!is_null($this->expiry)) ? $return['expiry'] = $this->expiry->getHexVal() : NULL; 
      (!is_null($this->ttl)) ? $return['ttl'] = $this->ttl->getHexVal() : NULL; 
      (!is_null($this->sent)) ? $return['sent'] = $this->sent->getHexVal() : NULL; 
      (!is_null($this->topics)) ? $return['topics'] = $this->topics->getHexVal() : NULL; 
      (!is_null($this->payload)) ? $return['payload'] = $this->payload->getHexVal() : NULL; 
      (!is_null($this->workProved)) ? $return['workProved'] = $this->workProved->getHexVal() : NULL; 
    return $return;
  }
}