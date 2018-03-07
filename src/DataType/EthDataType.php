<?php

namespace Ethereum\DataType;

use Exception;
use Ethereum\DataType\EthDataTypeInterface;
use Ethereum\DataType\EthD;
use Ethereum\EthereumStatic;
use Ethereum\Ethereum;
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
     * Check if Type is a primitive type.
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
     * @param bool   $hex_val
     *   Set to TRUE to get the hexadecimal value.
     *
     * @throw Exception
     *   If property does not exist.
     *
     * @return string|int|array
     *   The property value.*
     */
    public function getProperty($property = 'value', $hex_val = false)
    {

        if (property_exists($this, $property)) {

            if (is_object($this->$property)) {
                return ($hex_val) ? $this->$property->hexval() : $this->$property->val();
            }

            if (is_array($this->$property)) {
                $return = [];
                foreach ($this->$property as $item) {
                    if (is_object($item)) {
                        $return[] = ($hex_val) ? $item->hexval() : $item->val();
                    }
                }

                return $return;
            }
        } else {
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
     * @throws Exception
     *   If validation is not implemented for type.
     */
    public function setValue($val, array $params = [])
    {
        if (method_exists($this, 'validate')) {
            $this->value = $this->validate($val, $params);
        } else {
            throw new Exception('Validation of ' . __METHOD__ . ' not implemented yet.');
        }
    }

    /**
     * Determine type class name for primitive and complex data types.
     *
     * @param array|string $type
     *   Type containing Schema name.
     * @param bool         $typed_constructor
     *   If true this function will return "array" for types of array($type),
     *   instead of $type.
     *
     * @return string
     *   Class name of type.
     *
     * @throws Exception Could not determine type class
     */
    public static function getTypeClass($type, $typed_constructor = false)
    {

        if (!is_array($type)) {
            $primitive_type = EthD::typeMap($type);
        }
        else {
            $primitive_type = EthD::typeMap($type[0]);
        }

        if ($primitive_type) {
            $type_class = $primitive_type;
        }
        else {
            // Sadly arrayOf <type> is not supported by PHP.
            if ($typed_constructor) {
                $type_class = is_array($type) ? 'array' : $type;
            }
            else {
                $type_class = is_array($type) ? $type[0] : $type;
            }
        }

        if (!$type_class) {
            throw new Exception('Could not determine type class at getTypeClass()');
        }

        return $type_class;
    }


    /**
     * Returns array of all existing data type class names.
     *
     * @return array Array with names of all type classes.
     */
    public static function getAllTypeClasses() {
        $schema = Ethereum::getDefinition();
        return array_merge(
            EthD::getPrimitiveTypes(),
            array_keys($schema['objects'])
        );
    }
}

