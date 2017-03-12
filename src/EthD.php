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

    if ($this->hasHexPrefix($val) && $this->validateHexString($val)) {

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
   * Validate hex string for Hex letters.
   *
   * @param string $val
   *   Prefixed Hexadecimal String.
   *
   * @return bool
   *   Return TRUE if value contains only Hex digits.
   *
   * @throws \InvalidArgumentException
   *   If value contains non Hexadecimal characters.
   */
  public function validateHexString($val) {
    if ($val === '0x') {
      $val = '0x0';
    }
    if (!ctype_xdigit(substr($val, 2))) {
      throw new \InvalidArgumentException('A non well formed hex value encountered: ' . $val);
    }
    return TRUE;
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
