<?php

namespace Ethereum;

/**
 * Base Class for all Data types.
 */
class EthDataType {

  /**
   * Validate and set $value.
   *
   * @param String $property - Property to set.
   * @param Mixed $value - Input value.
   */
  public function set($value, $property = 'value') {
    if (property_exists($this, $property)) {
     call_user_func(array($this, 'set' . ucfirst($property)), $value);
    }
    else {
      throw new \InvalidArgumentException("Property '$property' does not exist.");
    }
  }

  /**
   * Get hexadecimal representation of $value.
   */
  public function getHexVal($property = 'value') {
    if (property_exists($this, $property)) {

      // TODO
      // VALUE TO HEX NOT IMPLEMENTED !
      return $this->$property;
    }
    else {
      throw new \InvalidArgumentException("Property '$property' does not exist.");
    }
  }
}
