<?php

namespace Ethereum;
use Exception;

/**
 * Basic Ethereum data types.
 *
 * @see: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI#types
 *
 * @ingroup dataTypesPrimitive
 */
class EthDataTypePrimitive extends EthDataType
{
    protected $value;

    const MAP = [
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

    public static function getPrimitiveTypes() {
        return ['EthD', 'EthD20', 'EthD32', 'EthQ', 'EthB', 'EthS'];
    }

    /**
     * Constructor.
     *
     * @param string|int $val
     *   Hexadecimal or number value.
     * @param array $params
     *   Array with optional parameters. Add Abi type $params['abi'] = 'unint8'.
     * @throw Exception
     */
    public function __construct($val, array $params = [])
    {
        $this->setValue($val, $params);
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
     * @throw Exception
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
     * @param string $abi
     *   Expected Abi type.
     *
     * @return object
     *   Return object of the expected data type.
     */
    public function convertTo($abi)
    {
        $class = '\Ethereum\\' . $this->typeMap($abi);
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
    public function toArray() {
        return array(
            'value' => $this->value,
        );
    }

}
