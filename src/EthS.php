<?php

namespace Ethereum;

/**
 * String data.
 */
class EthS extends EthD {

  /**
   * Implement validation.
   */
  public function validate($val) {
    $return = NULL;
    if ($this->hasHexPrefix($val)) {
      // Hex encoded string.
      $return = $this->hexToStr($val);
    }
    elseif (is_string($val)) {
      $return = $val;
    }
    if ($return && is_string($return)) {
      return $return;
    }
    else {
      throw new \InvalidArgumentException('Can not decode Hex string: ' . $val);
    }
  }

  /**
   * Implement validation.
   */
  public function hexVal() {
    return $this->strToHex($this->value);
  }

}
