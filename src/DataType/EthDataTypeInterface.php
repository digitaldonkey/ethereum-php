<?php
/**
 * @file
 * Ethereum data type API.
 *
 * @ingroup interfaces
 */

namespace Ethereum\DataType;
use Exception;

interface EthDataTypeInterface
{

    /**
     * Check if Type is a primitive type.
     *
     * @return bool
     *   True if data type is primitive.
     */
    public static function isPrimitive();


  /**
   * Get length of this data type.
   *
   * @return string [dynamic|fixed]
   *
   */
    public static function getDataLengthType();

    /**
     * Get property value.
     *
     * @param string $property
     *   Name of the property. Defaults to 'value'.
     * @param bool $hex_val
     *   Set to TRUE to get the hexadecimal representation of the property.
     *
     * @throws Exception
     *   If something is wrong.
     *
     * @return string|int|array
     *   The property value.*
     */
    public function getProperty(string $property = 'value', bool $hex_val = false);

    /**
     * Set a value with validation.
     *
     * Validation is implemented in subclasses.
     *
     * @param mixed $val
     *   Value to set.
     * @param array $params
     *   Array with optional keyed arguments.
     *
     * @throws Exception
     *   If validation is not implemented for type.
     */
    public function setValue($val, array $params = []);

    /**
     * Determine type class name for primitive and complex data types.
     *
     *
     * @param string $type
     *   Type containing Schema name.
     *
     * @param bool $typed_constructor
     *   If true this function will return "array" for types of array($type),
     *   instead of $type.
     *
     * @return string
     *   Class name of type.
     *
     * @throws Exception Could not determine type class
     */
    public static function getTypeClass(string $type, bool $typed_constructor = false);

    /**
     * Array of the value types.
     *
     * @return array
     *   Associative array with properties mapped to value types.
     */
    public function toArray();

}
