<?php

namespace Ethereum;

/**
 * Base Class for all Data types.
 */
class EthDataType extends EthereumStatic {

//  /**
//   * Validate and set $value.
//   *
//   * @param mixed $value
//   *   Input value.
//   * @param string $property
//   *   Property to set.
//   */
//  public function set($value, $property = 'value') {
//    if (property_exists($this, $property)) {
//      call_user_func(array($this, 'set' . ucfirst($property)), $value);
//    }
//    else {
//      throw new \InvalidArgumentException("Property '$property' does not exist.");
//    }
//  }

  /**
   * Get hexadecimal representation of $value.
   */
  public function getProperty($property = 'value') {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
    else {
      throw new \InvalidArgumentException("Property '$property' does not exist.");
    }
  }

  /**
   * Validation is implemented in subclasses.
   *
   * @param mixed $val
   *   Value to set.
   * @param array $params
   *   Array with optional keyed arguements.
   *
   * @throws \Exception
   *   If validation is not implemented for type.
   */
  public function setValue($val, array $params = array()) {
    if (method_exists($this, 'validate')) {
      $this->value = $this->validate($val, $params);
    }
    else {
      throw new \Exception('Validation of ' . __METHOD__ . ' not implemented yet.');
    }
  }

}
