<?php

namespace Ethereum\DataType;

use Ethereum\Ethereum;
use Ethereum\EthereumStatic;


/**
 * @defgroup dataTypes Data Types
 *
 * All data types in Ethereum-PHP are derived from EthDataType.
 */

/**
 * @defgroup interfaces Interfaces
 *
 * All Interfaces.
 */

/**
 * @defgroup dataTypesPrimitive Primitive Types
 *
 * All data primitive types in Ethereum-PHP are derived from EthD.
 *
 * @ingroup dataTypes
 */

/**
 * @defgroup dataTypesComplex Complex Types
 *
 * All data types in Ethereum-PHP are derived from EthDataType.
 *
 * @ingroup dataTypes
 */


/**
 * Base Class for all Data types.
 *
 * @ingroup dataTypes
 *
 */
abstract class EthDataType extends EthereumStatic implements EthDataTypeInterface
{

    /**
     * @const ABI_MAP
     *   Mapping ABI types to PHP classes.
     * @see https://solidity.readthedocs.io/en/develop/abi-spec.html#types
     */
    private const ABI_MAP = [
        // The following elementary types exist:
        'uint' => 'EthQ',
        'int' => 'EthQ',
        'address' => 'EthD20',
        // = uint 160?
        'bool' => 'EthB',
        // function, an address (20 bytes) followed by a function selector (4 bytes).
        // Encoded identical to bytes24
        // 'function' => ''

        // Fixed signed fixed-point decimal number of M bits, 8 <= M <= 256
        // @todo fixed-point decimal number not implemented.
        // 'fixed' => 'EthB',
        // 'ufixed' => 'EthS',

        // string: dynamic sized unicode string assumed to be UTF-8 encoded.
        'string' => 'EthS',
        // bytes: dynamic sized byte sequence.
        'bytes' => 'EthBytes',

        // Small Bytes < 32
        // Are always padded to 32bytes (64 chars in hex).
        //
        // bytes<M>: enc(X) is the sequence of bytes in X padded
        //  with trailing zero-bytes to a length of 32 bytes.
        //
        // bytes<M>: binary type of M bytes, 0 < M <= 32
        'bytes1' => 'EthD32',
        'bytes2' => 'EthD32',
        'bytes3' => 'EthD32',
        'bytes4' => 'EthD32',
        'bytes5' => 'EthD32',
        'bytes6' => 'EthD32',
        'bytes7' => 'EthD32',
        'bytes8' => 'EthD32',
        'bytes9' => 'EthD32',
        'bytes10' => 'EthD32',
        'bytes11' => 'EthD32',
        'bytes12' => 'EthD32',
        'bytes13' => 'EthD32',
        'bytes14' => 'EthD32',
        'bytes15' => 'EthD32',
        'bytes16' => 'EthD32',
        'bytes17' => 'EthD32',
        'bytes18' => 'EthD32',
        'bytes19' => 'EthD32',
        'bytes20' => 'EthD20',
        'bytes21' => 'EthD32',
        'bytes22' => 'EthD32',
        'bytes23' => 'EthD32',
        'bytes24' => 'EthD32',
        'bytes25' => 'EthD32',
        'bytes26' => 'EthD32',
        'bytes27' => 'EthD32',
        'bytes28' => 'EthD32',
        'bytes29' => 'EthD32',
        'bytes30' => 'EthD32',
        'bytes31' => 'EthD32',
        'bytes32' => 'EthD32',

        // @todo Function not implemented.
        // An address (20 bytes) followed by a function selector (4 bytes).
        // Encoded identical to bytes24
        // 'function'         => 'EthD32' // ??? Might require a ABI bytes24 that the value won't get zero padded.
    ];


    /**
     * Get PHP-class by ABI.
     *
     * @param string $abiType
     *  Ethereum ABI type. See https://solidity.readthedocs.io/en/develop/abi-spec.html#types
     *
     * @return string
     *   Name spaced class, you may use to do things like: `new $class($myVal)`
     *
     * @throws \Exception
     */
    public static function getClassByAbi(string $abiType)
    {
        $ns = 'Ethereum\DataType\\';

        // Exact types
        // Are exact keys in ABI_MAP
        // (e.g: bool, address, bytes, string)
        if (isset(self::ABI_MAP[$abiType])) {
            return $ns . self::ABI_MAP[$abiType];
        }

        // Int types (int*, uint*)
        $int = [];
        preg_match("/^(?'type'[u]?int)([\d]*)$/", $abiType, $int);
        // @see https://regex101.com/r/7JHrKG/1
        if ($int && isset(self::ABI_MAP[$int['type']])) {
            return $ns . self::ABI_MAP[$int['type']];
        }

        throw new \Exception('Unknown ABI type: ' . $abiType);
    }


    /**
     * Every Data class is 'static' or 'dynamic'.
     *
     * @see: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI#types
     *
     * @return string
     */
    public static function getDataLengthType()
    {
        return 'dynamic';
    }

    /**
     * Check if Type is a primitive type.
     *
     * Primitive types are implemented manually, while the complex types are
     * generated with `php scripts/generate-complex-datatypes.php` using
     * resources/ethjs-schema.json['objects'] as a source.
     *
     * @return bool
     *   True if data type is primitive.
     */
    public static function isPrimitive()
    {
        return false;
    }


    /**
     * Get hexadecimal representation of $value.
     *
     * @param string $property
     *   Name of the property.
     *
     * @param bool $returnHexVal
     *   Set to TRUE to get the hexadecimal value.
     *
     * @throws \InvalidArgumentException
     *   If property does not exist.
     *
     * @return string|int|array
     *   The property value.*
     */
    public function getProperty(string $property = 'value', bool $returnHexVal = false)
    {
        if (property_exists($this, $property)) {

            if (is_object($this->$property)) {
                return ($returnHexVal) ? $this->$property->hexval() : $this->$property->val();
            }

            if (is_array($this->$property)) {
                $return = [];
                foreach ($this->$property as $item) {
                    if (is_object($item)) {
                        $return[] = ($returnHexVal) ? $item->hexval() : $item->val();
                    }
                }
                return $return;
            }
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
     *
     * @param array $params
     *   Array with optional keyed arguments.
     *
     * @throws \Exception
     *   If validation is not implemented for type.
     */
    public function setValue($val, array $params = [])
    {
        if (method_exists($this, 'validate')) {
            if (isset($params['abi'])) {
                $this->abi = $params['abi'];
            }
            $this->value = $this->validate($val, $params);
        }
        else {
            throw new \Exception('Validation of ' . __METHOD__ . ' not implemented yet.');
        }
    }


    /**
     * Get type class name.
     *
     * @return string ClassName without namespace.
     */
    public function getClassName()
    {
        $ex = explode("\\", get_class($this));
        return end($ex);
    }


    /**
     * Determine type class name for primitive and complex data types.
     *
     * @param string $type
     *   Type containing Schema name. Might be "[D20]" to indicate an array
     *
     * @param bool $typed_constructor
     *   If true this function will return "array" for types of array($type),
     *   instead of $type.
     *
     * @return string
     *   Class name of type.
     *
     * @throws \Exception Could not determine type class
     */
    public static function getTypeClass(string $type, bool $typed_constructor = false)
    {
        $isArray = FALSE;
        // Handling "[type]".
        if (strpos($type, '[') !== FALSE) {
            $type = str_replace(['[', ']'], '', $type);
            $isArray = TRUE;
        }

        $primitive_type = EthD::typeMap($type);

        if ($primitive_type) {
            $type_class = $primitive_type;
        }
        else {
            // Sadly arrayOf <type> is not supported by PHP.
            if ($typed_constructor) {
                $type_class = $isArray ? 'array' : $type;
            }
            else {
                $type_class = $type;
            }
        }

        if (!$type_class) {
            throw new \Exception('Could not determine type class at getTypeClass()');
        }

        return $type_class;
    }


    /**
     * Returns array of all existing data type class names.
     *
     * @return array Array with names of all type classes.
     */
    public static function getAllTypeClasses()
    {
        $schema = Ethereum::getDefinition();
        return array_merge(
          EthD::getPrimitiveTypes(),
          array_keys($schema['objects'])
        );
    }
}

