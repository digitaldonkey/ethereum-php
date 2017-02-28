<?php

namespace Ethereum;

/**
 * Default block parameter.
 *
 * @see: https://github.com/ethereum/wiki/wiki/JSON-RPC#the-default-block-parameter.
 */
class EthBlockParam extends EthD20 {

  /**
   * Constructor.
   */
  public function __construct($block = 'latest') {
    $this->value = $block;
  }

}
