<?php

namespace Ethereum;

// Math_BigInteger
// https://pear.php.net/package/Math_BigInteger/docs/latest/Math_BigInteger/Math_BigInteger.html.
use Math_BigInteger;

/**
 * Numeric data.
 */
class EthQ extends EthD {

  // Validation properties.
  protected $intTypes = array('int', 'uint');

  // Property types.
  // $value will be a Math_BigInteger type.
  // Visibility public, so you can interact with Math_BigInteger.
  public $value;
  protected $abi;

  // Non not RLP encoded values have a hex padding length of 64 (strlen).
  // See:https://github.com/ethereum/wiki/wiki/RLP
  const HEXPADDING = 64;

  /**
   * Overriding constructor.
   *
   * @param string|int $val
   *   Hexadecimal or number value.
   * @param array $params
   *   Array with optional parameters. Add Abi type $params['abi'] = 'unint8'.
   */
  public function __construct($val, array $params = array()) {
    parent::__construct($val, $params);
  }

  /**
   * Implement validation.
   *
   * @param string|number $val
   *   "0x"prefixed hexadecimal or number value.
   * @param array $params
   *   Only $param['abi'] is relevant.
   *
   * @throws \Exception
   *   If things are wrong.
   *
   * @return Math_BigInteger.
   */
  public function validate($val, array $params) {
    $big_int = NULL;
    $abi = isset($params['abi']) ? $params['abi'] : NULL;

    if ($this->hasHexPrefix($val)) {

      // All Hex strings are lowercase.
      $val = strtolower($val);

      // Hex encoded number.
      // Math_BigInteger($val, $base)
      // A negative base will encode using wo's compliment.

      // Test for two's complement.
      // With this we can guess negative values if no ABI is given.
      // But it will trigger negative if we have the highest number
      // a of current hex length.

      // TODO
      // This is WRONG We need to check for RLP
      // SEE: https://github.com/ethereum/wiki/wiki/RLP
      if (!$abi && strlen($val) >= 10 && $val[2] === 'f') {
        $big_int = new Math_BigInteger($val, -16);
        $big_int->is_negative = TRUE;
      }
      else {
        // defaults to unsigned int if no abi is given.
        $big_int = new Math_BigInteger($val, 16);
      }
    }
    elseif (is_numeric($val)) {
      if ($val < 0) {
        $big_int = new Math_BigInteger($val);
        $big_int->is_negative = TRUE;
      }
      else {
        $big_int = new Math_BigInteger($val);
      }
    }
    if ($big_int && is_a($big_int, 'Math_BigInteger')) {

      $this->abi = $this->getAbiFromNumber($big_int);

      // Check for valid ABI type. If exists, generate it.
      if ($abi && $this->validateAbi($abi)) {
        if ($this->abi !== $params['abi']) {
          throw new \InvalidArgumentException('Given ABI (' . $params['abi'] . ') does not match number given number: ' . $val);
        }
      }
      return $big_int;
    }
    else {
      throw new \InvalidArgumentException('Can not decode Hex number: ' . $val);
    }
  }

  /**
   * getAbiFromIntVal().
   *
   * @param Math_BigInteger $number
   *   "0x" prefixed Hexadecimal value.
   * @return string
   *   Abi type.
   */
  protected function getAbiFromNumber(Math_BigInteger $number) {
    $abi_l = NULL;
    $negative = $number->is_negative;

    if ($negative) {
      $number = $number->multiply(new Math_BigInteger(-1));
    }

    foreach ($this->getValidLengths() as $exp) {

      $max_for_exp = new Math_BigInteger(2);
      $max_for_exp = $max_for_exp->bitwise_leftShift($exp - 1);

      // Prevent overflow See: http://ethereum.stackexchange.com/a/7294/852.
      $max_for_exp = $max_for_exp->subtract(new Math_BigInteger(1));

      if ($number->compare($max_for_exp) <= 0) {
        $abi_l = $exp;
        break;
      }
    }
    if (!$abi_l) {
      throw new \InvalidArgumentException('NOT IN RANGE: ' . $number->toString() . ' > (u)int256');
    }
    if ($negative) {
      return 'int' . $abi_l;
    }
    else {
      // Default to unsigned integer.
      return 'uint' . $abi_l;
    }
  }

  /**
   * Validate ABI.
   *
   * See: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI#types.
   *
   * @param string $abi
   *   Valid Abi for number. E.g uint8, int160 ...
   *
   * @throws \InvalidArgumentException
   *   If Abi don't match definition.
   *
   * @return bool TRUE if abi matches definition.
   */
  protected function validateAbi($abi) {
    $abiObj = $this->splitAbi($abi);
    $valid_length = in_array($abiObj->intLength, $this->getValidLengths());
    $valid_type = in_array($abiObj->intType, $this->intTypes);
    if (!($valid_length || $valid_type)) {
      throw new \InvalidArgumentException('Can not validate ABI: ' . $abi);
    }
    return TRUE;
  }


  /**
   * Split abi type into length and intType.
   */
  protected function splitAbi($abi) {
    $matches = array();
    $valid = NULL;
    // See: https://regex101.com/r/3XYumB/1
    if (preg_match('/^(u?int)(\d{1,3})$/', $abi, $matches)) {
      return (object) array(
        'abi' => $abi,
        'intType' => $matches[1],
        'intLength' => $matches[2],
      );
    }
    else {
      throw new \InvalidArgumentException('Could not decode ABI for: ' . $abi);
    }
  }

  /**
   * Implement hex value.
   */
  public function hexVal() {

    // Ethereum requires two's complement.
    // Math_BigInteger->toHex( [Boolean $twos_compliment = false])
    $value = $this->value->toHex($this->value->is_negative);

    if (strlen($value) > self::HEXPADDING) {
      throw new \Exception('Values > (u)int32 not supported yet: ' . $value);
    }

    // Calc padding.
    $pad = self::HEXPADDING - strlen($value);

    $fill = $this->value->is_negative ? 'f' : '0';
    $ret = '0x' . str_repeat($fill, $pad) . $value;
    return $ret;
  }

  /**
   * Implement getLength().
   */
  public function getLength() {
    $type = $this->splitAbi($this->abi);
    return $type->intLength;
  }

  /**
   * Implement hex value.
   */
  public function isNegative($abi = FALSE) {
    if (!$abi) {
      $type = $this->splitAbi($this->abi);
    }
    else {
      $type = $abi;
    }

    if ($type->abi === 'uint') {
      return FALSE;
    }
    else {
      return TRUE;
    }
  }

  /**
   * Check if number is large.
   *
   * @param Math_BigInteger $val
   *   Math_BigInteger value.
   *
   * @return bool
   *   Return TRUE if number > PHP_INT_MAX.
   */
  public function isLargeNumber(Math_BigInteger $val) {
    return !((string) ((int) $val->toString()) === $val->toString());
  }

  /**
   * Implement Integer value.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function val() {
    if ($this->isLargeNumber($this->value)) {
      return $this->value->toString();
    }
    else {
      return (int) $this->value->toString();
    }
  }

  /**
   * Implement Integer value.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function getAbi() {
    return $this->abi;
  }

}
