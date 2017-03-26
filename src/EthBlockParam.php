<?php

namespace Ethereum;

/**
 * Default block parameter.
 *
 * @see: https://github.com/ethereum/wiki/wiki/JSON-RPC#the-default-block-parameter.
 */
class EthBlockParam extends EthD20 {

  const TAGS = array(
    "latest",
    "earliest",
    "pending",
  );

  /**
   * Constructor.
   *
   * @param string|int $val
   *   Hexadecimal or number value.
   * @param array $params
   *   Array with optional parameters. Add Abi type $params['abi'] = 'unint8'.
   */
  public function __construct($val = 'latest', array $params = array()) {
    parent::__construct($val, $params);
  }

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

    if (in_array($val, $this::TAGS)) {
      $return = $val;
    }
    else {
      $return = $this->validateAddress($val, $params);
    }

    if (!$return) {
      throw new \InvalidArgumentException('Can not decode hex binary: ' . $val);
    }
    return $return;
  }

  /**
   * Return un-prefixed bin value.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function val() {
    if (in_array($this->value, $this::TAGS)) {
      return $this->value;
    }
    else {
      return substr($this->value, 2);
    }
  }

  /**
   * Return hex value or tag.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function hexVal() {
    if (in_array($this->value, $this::TAGS)) {
      return $this->value;
    }
    else {
      return $this->value;
    }
  }

  /**
   * Call EthD20 validation to validate Address.
   */
  protected function validateAddress($val, array $params) {
    return parent::validate($val, $params);
  }

}
