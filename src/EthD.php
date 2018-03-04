<?php

namespace Ethereum;
use Math_BigInteger;

/**
 * Basic Ethereum data types.
 *
 * Can be bool, integer, data, lists, arrays...
 * @see: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI#types
 *
 * @ingroup dataTypesPrimitive
 */
class EthD extends EthDataType
{

    protected $value;

    private const MAP = [
        // Bytes data.
      'D'                  => 'EthD',
        // Bytes data, length 20
        // 40 hex characters, 160 bits. E.g Ethereum Address.
      'D20'                => 'EthD20',
        // Bytes data, length 32
        // 64 hex characters, 256 bits. Eg. TX hash.
      'D32'                => 'EthD32',
        // Number quantity.
      'Q'                  => 'EthQ',
        // Boolean.
      'B'                  => 'EthB',
        // String data.
      'S'                  => 'EthS',
        // Default block parameter: Address/D20 or tag [latest|earliest|pending].
      'Q|T'                => 'EthBlockParam',
        // Either an array of DATA or a single bytes DATA with variable length.
      'Array|DATA'         => 'EthData',
        // Derived ABI types
      'bool'               => 'EthB',
        // WORKAROUND? Some clients may return an Data Array. Works on testrpc.
      'B|EthSyncing' => 'EthB',
        // WORKAROUND? Some clients may return an Data Array. Works on testrpc.
      'DATA|Transaction'   => 'Transaction',
        /// @todo DATA OR Transaction ???
    ];


    /**
     * @var Mapping ABI types to PHP classes.
     */
    private const abiMap = [
        // Bytes data.
      'uint'                  => 'EthD',
        // Bytes data, length 20
        // 40 hex characters, 160 bits. E.g Ethereum Address.
      'int'                => 'EthD20',
        // Bytes data, length 32
        // 64 hex characters, 256 bits. Eg. TX hash.
      'address'                => 'EthD32',
        // Number quantity.
      'bool'                  => 'EthQ',
        // Boolean.
      'fixed'                  => 'EthB',
        // String data.
      'ufixed'                  => 'EthS',
        // Default block parameter: Address/D20 or tag [latest|earliest|pending].
      'bytes'                => 'EthBlockParam',
        // Either an array of DATA or a single bytes DATA with variable length.
      'function'         => 'EthData',
        // Derived ABI types
      'string'               => 'EthB',
    ];

    /**
     * Constructor.
     *
     * @param mixed $val
     *   Hexadecimal or number value.
     *
     * @param array $params
     *   Array with optional parameters. Add Abi type $params['abi'] = 'unint8'.
     *
     * @throws \Exception
     */
    public function __construct($val, array $params = [])
    {
        $this->setValue($val, $params);
    }


    /**
     * Implement validation.
     *
     * @ingroup dataTypesPrimitive
     *
     * @param string $val
     *   "0x"prefixed hexadecimal byte value.
     * @param array  $params
     *   Only $param['abi'] is relevant.
     *
     * @throw InvalidArgumentException Can not decode hex binary
     *
     * @return string.
     */
    public function validate($val, array $params)
    {

        if ($this->hasHexPrefix($val) && $this->validateHexString($val)) {

            // All Hex strings are lowercase.
            $val = strtolower($val);
            if (method_exists($this, 'validateLength')) {
                $val = call_user_func([$this, 'validateLength'], $val);
            }

            return $val;
        } else {
            throw new \InvalidArgumentException('Can not decode hex binary: ' . $val);
        }
    }

    /**
     * Validate hex string for Hex letters.
     *
     * TODO This might be moved to EthereumStatic.
     *
     * @param string $val
     *   Prefixed Hexadecimal String.
     *
     * @return bool
     *   Return TRUE if value contains only Hex digits.
     *
     * @throw InvalidArgumentException
     *   If value contains non Hexadecimal characters.
     */
    public function validateHexString($val)
    {
        if ($val === '0x') {
            $val = '0x0';
        }
        if (!ctype_xdigit(substr($val, 2))) {
            throw new \InvalidArgumentException('A non well formed hex value encountered: ' . $val);
        }

        return true;
    }


    /**
     * Get an Array of all Data type classes.
     *
     * TODO This is incomplete.
     *
     * @return array
     */
    public static function getPrimitiveTypes() {
        return ['EthD', 'EthD20', 'EthD32', 'EthQ', 'EthB', 'EthS'];
    }

    /**
     * Check if Type is a primitive type.
     *
     * @return bool
     *   True if data type is primitive.
     */
    public static function isPrimitive()
    {
        return true;
    }

    /**
     * Map types.
     *
     * @param string $type
     *   Schema name of data type.
     *
     * @return string|bool
     *   Class name of data type or NULL if not exists.
     */
    public static function typeMap(string $type)
    {
        $map = self::MAP;
        if (isset($map[$type])) {
            return $map[$type];
        } else {
            return null;
        }
    }

    /**
     * ReverseTypeMap().
     *
     * @param string $class_name
     *   Classname of the type.
     *
     * @return string
     *    Schema name of the type.
     *
     * @throws \Exception
     */
    public static function reverseTypeMap($class_name)
    {
        $schema_type = array_search($class_name, self::MAP);
        if (is_string($schema_type)) {
            return $schema_type;
        } else {
            throw new \Exception('Could not determine data type.');
        }
    }

    /**
     * Get schema type of a primitive data type..
     *
     * @return string
     *   Returns the CLass name of the type or The schema name if $schema is TRUE.
     * @throw Exception
     */
    public static function getSchemaType()
    {
        $class_name = get_called_class();
        if (substr($class_name, 0, strlen(__NAMESPACE__)) === __NAMESPACE__) {
            // Cut of namespace and Slash. E.g "Ethereum\".
            $class_name = substr(get_called_class(), strlen(__NAMESPACE__) + 1);
        }
        return self::reverseTypeMap($class_name);
    }

    /**
     * Turn value into Expected value.
     *
     * @param string $abiType
     *   Expected Abi type.
     *
     * @return object
     *   Return object of the expected data type.
     */
    public function convertTo($abiType)
    {
        $class = '\Ethereum\\' . $this->typeMap($abiType);
        $obj = new $class($this->hexVal());

        return $obj;
    }

    /**
     * Array of properties.
     *
     * For primitive types the property is always 'value'.
     *
     * @return array
     *   Return object of the expected data type.
     */
    public static function getTypeArray() {
        return array(
          'value' => get_class(),
        );
    }

    /**
     * Converts object to an array.
     *
     * @return array
     *   Return object of the expected data type.
     */
    public function toArray()
    {
        return array(
          'value' => $this->value,
        );
    }


    /**
     * Return hex value.
     *
     * @return string
     *      Prefixed Hex value.
     */
    public function hexVal()
    {
        return $this->value;
    }

    /**
     * Return un-prefixed bin value.
     *
     * Subclasses may return other types.
     *
     * @return string
     *      Un-prefixed Hex value.
     */
    public function val()
    {
        return substr($this->value, 2);
    }

}
