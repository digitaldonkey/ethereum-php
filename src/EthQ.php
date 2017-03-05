<?php

namespace Ethereum;

// Math_BigInteger
// https://pear.php.net/package/Math_BigInteger/docs/latest/Math_BigInteger/Math_BigInteger.html.
use Math_BigInteger;

/**
 * Numeric data.
 */
class EthQ extends EthDataTypePrimitive {

  // Validation properties.
  protected $intTypes = array('int', 'uint');
  protected $intLengts = array();

  // Property types.
  // $value will be a Math_BigInteger type.
  // Visibility public, so you can interact with Math_BigInteger.
  public $value;
  protected $abi;

  /**
   * Overriding constructor.
   *
   * @param string|int $val
   *   Hexadecimal or number value.
   * @param array $params
   *   Array with optional parameters. Add Abi type $params['abi'] = 'unint8'.
   */
  public function __construct($val, array $params = array()) {
    // Valid types.
    $valid_lengths = "8;16;24;32;40;48;56;64;72;80;88;96;104;112;120;128;136;144;152;160;168;176;184;192;200;208;216;224;232;240;248;256";
    $this->intLengts = explode(';', $valid_lengths);
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
      if (!$abi && strlen($val) >= 10 && $val[2] === 'f') {
        $big_int = new Math_BigInteger($val, -16);
        $big_int->is_negative = TRUE;
      }
      else {
        // defaults to unsigned int if no abi is given.
        $big_int = new Math_BigInteger($val, 16);
      }
    }
    elseif (is_int($val)) {
      if ($val < 0) {
        $big_int = new Math_BigInteger($val);
        $big_int->is_negative = TRUE;
      }
      else {
        $big_int = new Math_BigInteger($val);
      }
    }
    if ($big_int && is_a($big_int, 'Math_BigInteger')) {
      // Check for valid ABI type. If exists, generate it.
      if ($abi && $this->validateAbi($abi)) {
        $this->abi = $params['abi'];
      }
      else {
        // Construct ABI from Hex.
        if ($this->hasHexPrefix($val)) {
          $this->abi = $this->getAbiFromHexVal($val, $big_int->is_negative);
        }
        else {
          // Construct ABI from Number.
          $this->abi = $this->getAbiFromNumber($big_int);
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
   * @return string Abi type.
   */
  protected function getAbiFromNumber(Math_BigInteger $number) {
    $val = $number->toHex($number->is_negative);
    $length = strlen($val);
    $max = array_slice(array_values($this->intLengts), -1)[0];
    while (!in_array($length, $this->intLengts)) {
      $length++;
      if ($length > $max) {
        throw new \Exception('Can not decode Hex number: ' . $val);
      }
    }
    if ($number->is_negative) {
      return 'int' . $length;
    }
    else {
      // Default to unsigned integer.
      return 'uint' . $length;
    }
  }

  /**
   * getAbiFromHexVal().
   *
   * @param string $hexVal
   *   "0x" prefixed Hexadecimal value.
   * @param bool $is_negative
   *   Set tr TRUE if number is negative.
   *
   * @return string Abi type.
   */
  protected function getAbiFromHexVal($hexVal, $is_negative = FALSE) {

    if ($hexVal === '0x' || $hexVal === '0x0') {
      $hexVal = '0x00000000';
    }

    $length = strlen($hexVal) - 2;

    if (!in_array($length, $this->intLengts)) {
      throw new \InvalidArgumentException('Invalid hex length for value : ' . $hexVal);
    }
    if ($is_negative) {
      return 'int' . $length;
    }
    else {
      // Default to unsigned integer.
      return 'uint' . $length;
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
    $valid_length = in_array($abiObj->intLength, $this->intLengts);
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

    // Calc padding.
    $pad = $this->getLength() - strlen($value);

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
   * Implement Integer value.
   *
   * @return int|string
   *   Return a PHP integer.
   *   If $val > PHP_INT_MAX we return a string containing the integer.
   */
  public function val() {

    $val = $this->value->toString();
    if ((string)((int) $val) === $val) {
      return (int) $val;
    }
    else {
      return $val;
    }
  }

}
