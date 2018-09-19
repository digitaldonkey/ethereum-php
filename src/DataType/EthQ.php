<?php

namespace Ethereum\DataType;

/* @see https://pear.php.net/package/Math_BigInteger/docs/latest/Math_BigInteger/Math_BigInteger.html Math_BigInteger documentation */
use Math_BigInteger;


/**
 * Numeric data.
 *
 * @ingroup dataTypesPrimitive
 */
class EthQ extends EthD
{
    // Validation properties.
    private $intTypes = ['int', 'uint'];

    // @var $value Math_BigInteger Math big integer pear library.
    public $value;

    /**
     * @var string $abi
     *    Abi of the content.
     * @see https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI Ethereeum Abi documentation
     */
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
     *
     * @throws Exception
     */
    public function __construct($val, array $params = [])
    {
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
     * @throws Exception
     *   If things are wrong.
     *
     * @return Math_BigInteger.
     */
    public function validate($val, array $params)
    {
        $big_int = null;
        $abi = isset($params['abi']) ? $params['abi'] : null;

        if ($this->hasHexPrefix($val)) {

            // All Hex strings are lowercase.
            $val = strtolower($val);

            // Some positive values are unprefixed. Enforcing left pad.
            if (strlen(self::removeHexPrefix($val)) < self::HEXPADDING) {
              $val = $this->padLeft($val);
            }

            // A negative base will encode using two's compliment.
            if ($val[2] === 'f') {
                $big_int = new Math_BigInteger($val, -16);
                $big_int->is_negative = true;
            }
            else {
                // defaults to unsigned int if no abi is given.
                $big_int = new Math_BigInteger($val, 16);
            }
        }
        elseif (is_numeric($val)) {
            if ($val < 0) {
                $big_int = new Math_BigInteger($val);
                $big_int->is_negative = true;
            }
            else {
                $big_int = new Math_BigInteger($val);
            }
        }
        if ($big_int && is_a($big_int, 'Math_BigInteger')) {

            $this->abi = $this->getAbiFromNumber($big_int);
            if ($abi) {
                // Will throw if ABI param is formally incorrect.
                $this->validateAbi($abi);

                if ($this->abi !== $abi) {

                    // Check if calculated ABI is a subset of the given API Param.
                    if ($this->getLength($this->abi) < $this->getLength($abi)) {
                        $this->abi = $abi;
                    }
                    else {
                        throw new \InvalidArgumentException(
                          'Given ABI (' . $abi . ') does not match number given number: ' . $val);
                    }
                }
            }
            return $big_int;
        }
        else {
            throw new \InvalidArgumentException('Can not decode Hex number: ' . $val);
        }
    }


    /**
     * Pad unpadded positive quantities.
     *
     * @param string
     *   Hexadecimal non-negative $value
     *
     * @return string
     *    Hex prefixed value padded to 32 bit.
     */
    private static function padLeft(string $val)
    {
      $unprefixed = self::removeHexPrefix($val);
      $fillUp = self::HEXPADDING - (strlen($unprefixed) % self::HEXPADDING);
      return self::ensureHexPrefix(str_repeat("0", $fillUp) . $unprefixed);
    }

    /**
     * getAbiFromIntVal().
     *
     * @param Math_BigInteger $number
     *   "0x" prefixed Hexadecimal value.
     * @return string
     *   Abi type.
     */
    protected function getAbiFromNumber(Math_BigInteger $number)
    {
        $abi_l = null;
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
     * @throw InvalidArgumentException
     *   If Abi don't match definition.
     *
     * @return bool TRUE if abi matches definition.
     */
    protected function validateAbi($abi)
    {
        $abiObj = $this->splitAbi($this->abiAliases($abi));
        $valid_length = in_array($abiObj->intLength, $this->getValidLengths());
        $valid_type = in_array($abiObj->intType, $this->intTypes);
        if (!($valid_length || $valid_type)) {
            throw new \InvalidArgumentException('Can not validate ABI: ' . $abi);
        }
        return true;
    }

    /**
     * @param $abi
     * @return string
     *   ABI with converted aliases.
     */
    private static function abiAliases($abi)
    {
        // uint, int: synonyms for uint256, int256 respectively.
        if ($abi === 'int') {
            $abi = 'int256';
        }
        if ($abi === 'uint') {
            $abi = 'uint256';
        }
        return $abi;
    }

    /**
     * Split abi type into length and intType.
     */
    protected static function splitAbi($abi)
    {
        $matches = [];
        $valid = null;
        // See: https://regex101.com/r/3XYumB/1
        if (preg_match('/^(u?int)(\d{1,3})$/', self::abiAliases($abi),
          $matches)) {
            return (object)[
              'abi' => $abi,
              'intType' => $matches[1],
              'intLength' => $matches[2],
            ];
        }
        else {
            throw new \InvalidArgumentException('Could not decode ABI for: ' . $abi);
        }
    }

    /**
     * Implement hex value.
     * @throws Exception
     */
    public function hexVal()
    {

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
     * Implement hex value.
     * @throws Exception
     */
    public function hexValUnpadded()
    {
        return '0x' . $this->value->toHex($this->value->is_negative);
    }

    /**
     * Implement getLength().
     */
    public function getLength($abi)
    {
        $type = $this->splitAbi($abi);

        return $type->intLength;
    }

    /**
     * Implement hex value.
     */
    public function isNegative($abi = false)
    {
        if (!$abi) {
            $type = $this->splitAbi($this->abi);
        }
        else {
            $type = $abi;
        }

        if ($type->abi === 'uint') {
            return false;
        }
        else {
            return true;
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
    public function isLargeNumber(Math_BigInteger $val)
    {
        return !((string)((int)$val->toString()) === $val->toString());
    }

    /**
     * Implement Integer value.
     *
     * @return int|string
     *   Return a PHP integer.
     *   If $val > PHP_INT_MAX we return a string containing the integer.
     */
    public function val()
    {
        if ($this->isLargeNumber($this->value)) {
            return $this->value->toString();
        }
        else {
            return (int)$this->value->toString();
        }
    }

    /**
     * @return string
     */
    public function encodedHexVal()
    {
        return $this->hexVal();
    }

    /**
     * Checks if value is not null.
     *
     * @return bool
     */
    public function isNotNull()
    {
        $null = new Math_BigInteger();
        return ($this->value->compare($null) > 0 || $this->value->compare($null) < 0);
    }

    /**
     * Implement Integer value.
     *
     * @return int|string
     *   Return a PHP integer.
     *   If $val > PHP_INT_MAX we return a string containing the integer.
     */
    public function getAbi()
    {
        return $this->abi;
    }

    /**
     * Valid number lengths.
     *
     * Array of valid M's, where
     *    % 8 == 0 && 8 <= M <= 256
     * @return array
     *   Array of valid integer lengths for (u)int and (u)fixed types.
     */
    public static function getValidLengths()
    {
        $valid_lengths = "8;16;24;32;40;48;56;64;72;80;88;96;104;112;120;128;136;144;152;160;168;176;184;192;200;208;216;224;232;240;248;256";
        return explode(';', $valid_lengths);
    }

    /**
     * @return string|int
     */
    public static function getDataLengthType()
    {
        return 'static';
    }
}
