<?php

class EthBlockParam extends EthD20 {

  public function __construct($block = 'latest') {
    $this->value = $block;
  }
}
