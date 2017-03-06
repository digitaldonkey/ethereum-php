<?php

namespace Ethereum;

use \Ethereum\EthDataTypePrimitive;

/**
 * Byte data.
 */
class EthD extends EthDataTypePrimitive {

  /**
   * Implement validation.
   *
   * @param string $val
   *   "0x"prefixed hexadecimal byte value.
   * @param array $params
   *   Only $param['abi'] is relevant.
   *
   * @throws \Exception
   *   If things are wrong.
   *
   * @return string.
   */
  public function validate($val, array $params) {

    $X = FALSE;

    if ($this->hasHexPrefix($val) && ctype_xdigit(substr(2, $val))) {

      // All Hex strings are lowercase.
      $val = strtolower($val);
      if (method_exists($this, 'validateLength')) {
        $val = call_user_func(array($this, 'validateLength'), $val);
      }
      return $val;
    }
    else {
      throw new \InvalidArgumentException('Can not decode hex binary: ' . $val);
    }
  }

  /**
   * Return unprefixed bin value.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function val() {
    return substr($this->value, 2);
  }

  /**
   * Implement Integer value.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function hexVal() {
    return $this->value;
  }

}
