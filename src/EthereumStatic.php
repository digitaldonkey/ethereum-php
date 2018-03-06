<?php

namespace Ethereum;
use Exception;
use kornrunner\Keccak;

/**
 * Static helper functions for Ethereum JsonRPC API for PHP.
 */
abstract class EthereumStatic
{
    /**
     * Get signature of a solidity method.
     *
     * Returns hash of the Smart contract method - it's signature.
     *
     * See:
     * https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI#function-selector
     *
     * @param string $input
     *   Method signature.
     *
     * @return string
     *   Hash of the method signature.
     */
    public static function getMethodSignature($input)
    {
        if (self::isValidFunction($input))
        {
            // The signature is 4bytes of the methods keccac hash. E.g: "0x00000000".
            return substr(self::sha3($input), 0, 10);
        }
        else
        {
            throw new \InvalidArgumentException("No valid (solidity) signature string provided.");
        }
    }


    /**
     * Determine type class name for primitive and complex data types.
     *
     * @param string $class_name
     *   Type to construct from associative Array.
     * @param array  $values
     *   Associative value array.
     *
     * @return object|array
     *   Object of type $class_name.
     *
     * @throw Exception
     *   If something is wrong.
     */
    public static function arrayToComplexType($class_name, array $values)
    {
        $return = [];
        $class_values = [];
        if (!substr($class_name, 1,8) === __NAMESPACE__) {
            $class_name = __NAMESPACE__  . "\\$class_name";
        }

        $type_map = $class_name::getTypeArray();

        foreach ($type_map as $name => $val_class) {
            if (isset($values[$name])) {
                $val_class = '\\Ethereum\\' . $val_class;
                if (is_array($values[$name])) {
                    $sub_values = [];
                    foreach ($values[$name] as $sub_val) {
                        // Work around testrpc giving not back an array.
                        if (is_array($sub_val)) {
                            $sub_values[] = self::arrayToComplexType($val_class, $sub_val);
                        } else {
                            $sub_values[] = [$sub_val];
                        }

                    }
                    $class_values[] = $sub_values;
                } else {
                    $class_values[] = new $val_class($values[$name]);
                }
            } else {
                // In order to create a proper constructor we need null values too.
                $class_values[] = null;
            }
        }
        $return = new $class_name(...$class_values);

        return $return;
    }

    /**
     * Get valid number lengths.
     *
     * @return array
     *   Array of valid integer lengths.
     */
    public static function getValidLengths()
    {
        $valid_lengths = "8;16;24;32;40;48;56;64;72;80;88;96;104;112;120;128;136;144;152;160;168;176;184;192;200;208;216;224;232;240;248;256";

        return explode(';', $valid_lengths);
    }

    /**
     * Create value array.
     *
     * Turns a array('0x56789...', ...) into array(EthD32(0x56789...), ...)
     *
     * @param array  $values
     *   Array of values of a unique data type.
     * @param string $typeClass
     *   Class name for the data type.
     *
     * @return array
     *   Array of value objects of the given type.
     * @throw Exception
     */
    public static function valueArray(array $values, $typeClass)
    {
        $return = [];
        if (!class_exists($typeClass)) {
            $typeClass = '\\' . __NAMESPACE__  . '\\' . $typeClass;
        }
        foreach ($values as $i => $val) {
            if (is_array($val)) {
                $return[$i] = self::arrayToComplexType($typeClass, $val);
            }
            $return[$i] = new $typeClass($val);
        }

        return $return;
    }

    /**
     * Keccak hash function.
     *
     * This is a a local version of web3_sha3() based on
     *   https://github.com/kornrunner/php-keccak
     *
     * Ethereum JsonRPC provides web3.sha3(), but  making a JsonRPC call for that
     * seems costly.
     *
     * Unlike web3's sha3 method suggests Ethereum is NOT using SHA3-256 standard
     * implementation (the NIST SHA3-256 became a standard later), but Keccak256.
     * Is is the pure Keccak[r=1088, c=512] implementation.
     *
     * @param string $string
     *   String to hash.
     *
     * @return string
     *   Keccak256 of the provided string.
     *
     * @throws \Exception
     *   If keccak hash does not match formal conditions.
     */
    public static function phpKeccak256($string)
    {
        $return = Keccak::hash($string, 256);
        $return = self::ensureHexPrefix($return);

        // Formal verification: Prefix + 64 Hex chars.
        if (!$return || strlen($return) !== 66)
        {
            throw new \Exception('keccak256 returns a wrong value.');
        }
        return $return;
    }


    /**
     * Wrapper to phpKeccak256($string)
     * @param $string
     */
    public static function sha3($string) {
        return self::phpKeccak256($string);
    }

    /**
     * Is valid function.
     *
     * @todo Pretty basic solidity function verification might need improvement.
     *
     * @param string $input
     *   Function ABI as string.
     *   See: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI.
     *
     * @return bool
     *   True if it might be a valid solidity function.
     */
    public static function isValidFunction($input)
    {
        // Check for function and Params.
        // See: https://regex101.com/r/437FZz/1/
        $regex = '/^[a-zA-Z]*[\(]{1}(([\w\d]*)|([\w\d]*\s[\w\d]*){1}(\,\s[\w\d]*\s[\w\d]*)+)[\)]{1}$/';
        if (is_string($input) && preg_match($regex, $input) === 1) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve the Ethereum JsonRPC API definition.
     *
     * Normally the content of the file resources/ethjs-schema.json.
     *
     * @return array
     */
    public static function getDefinition()
    {
        $schema_path = __DIR__ . '/../resources/ethjs-schema.json';
        return json_decode(file_get_contents($schema_path), true);
    }

    /**
     * Decodes a HEX encoded number.
     *
     * See:
     * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
     *
     * This is now handled by Math_BigInteger
     * https://pear.php.net/package/Math_BigInteger/docs/latest/Math_BigInteger/Math_BigInteger.html.
     *
     * See class EthQ.
     */

    /**
     * Tests string for valid hex quantity.
     *
     * See:
     * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
     *
     * @param string $str
     *   String to test for Hex.
     *
     * @return bool
     *   TRUE if string is a Valid Hex value or FALSE.
     */
    public static function isValidHexQuantity($str)
    {

        // Always ensure 0x prefix.
        if (!EthereumStatic::hasHexPrefix($str)) {
            return false;
        }

        // Should always have at least one digit - zero is "0x0".
        if (strlen($str) < 3) {
            return false;
        }

        return ctype_xdigit(self::removeHexPrefix($str));
    }

    /**
     * Tests if the given string is a HEX UNFORMATED DATA value.
     *
     * See:
     * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
     *
     * @param string $str
     *   String to test for Hex.
     *
     * @return bool
     *   TRUE if string is a Valid Hex value or FALSE.
     */
    public static function isValidHexData($str)
    {

        // Always ensure 0x prefix.
        if (!EthereumStatic::hasHexPrefix($str)) {
            return false;
        }
        // Should always have at least one digit - zero is "0x0".
        if (strlen($str) <= 3) {
            return false;
        }

        // Ensure two hex digits per byte.
        if ((strlen($str) % 2 != 0)) {
            return false;
        }

        return ctype_xdigit(self::removeHexPrefix($str));
    }

    /**
     * Check for a valid Ethereum address.
     *
     * Tests if the given string qualifies as a Ethereum address.
     * (DATA, 20 Bytes - address)
     *
     * @param string $address
     *   String to test for Address.
     * @param bool   $throw
     *   If TRUE we will throw en error.
     *
     * @return bool
     *   TRUE if string is a Valid Address value or FALSE.
     */
    public static function isValidAddress($address, $throw = false)
    {

        if (!self::hasHexPrefix($address)) {
            return false;
        }
        // Address should be 20bytes=40 HEX-chars + prefix.
        if (strlen($address) !== 42) {
            return false;
        }
        $return = ctype_xdigit(self::removeHexPrefix($address));

        if (!$return && $throw) {
            throw new \InvalidArgumentException($address . ' has invalid format.');
        }

        return $return;
    }

    /**
     * Test if a string is prefixed with "0x".
     *
     * @param string $str
     *   String to test prefix.
     *
     * @return bool
     *   TRUE if string has "0x" prefix or FALSE.
     */
    public static function hasHexPrefix($str)
    {
        return substr($str, 0, 2) === '0x';
    }

    /**
     * Remove Hex Prefix "0x".
     *
     * @param string $str
     *   String with prefix.
     *
     * @return string
     *   String without prefix.
     */
    public static function removeHexPrefix($str)
    {
        if (!self::hasHexPrefix($str)) {
            throw new \InvalidArgumentException('String is not prefixed with "0x".');
        }

        return substr($str, 2);
    }

    /**
     * Add Hex Prefix "0x".
     *
     * @param string $str
     *   String without prefix.
     *
     * @return string
     *   String with prefix.
     */
    public static function ensureHexPrefix($str)
    {
        if (self::hasHexPrefix($str)) {
            return $str;
        }

        return '0x' . $str;
    }

    /**
     * Converts a string to Hex.
     *
     * @param string $string
     *   String to be converted.
     *
     * @return string
     *   Hex representation of the string.
     */
    public static function strToHex($string)
    {
        $hex = unpack('H*', $string);

        return '0x' . array_shift($hex);
    }

    /**
     * Converts Hex to string.
     *
     * @param string $string
     *   Hex string to be converted to UTF-8.
     *
     * @return string
     *   String value.
     *
     * @throws Exception
     */
    public static function hexToStr($string)
    {

        if (!self::hasHexPrefix($string)) {
            throw new Exception('String is missing Hex prefix "0x" : ' . $string);
        }
        $string = substr($string, strlen('0x'));
        $utf8 = '';

        $letters = str_split($string, 2);
        foreach ($letters as $letter) {
            $utf8 .= html_entity_decode("&#x$letter;", ENT_QUOTES, 'UTF-8');
        }

        return $utf8;

        // Dosn't tackle Line 18
        // if ($string < 128) {
        //   $utf = chr($string);
        // }
        // elseif ($string < 2048) {
        //   $utf = chr(192 + (($string - ($string % 64)) / 64));
        //   $utf .= chr(128 + ($string % 64));
        // }
        // else {
        //  $utf = chr(224 + (($string - ($string % 4096)) / 4096));
        //  $utf .= chr(128 + ((($string % 4096) - ($string % 64)) / 64));
        //  $utf .= chr(128 + ($string % 64));
        //}

        // Can't handle Ö
        // $utf8 = hex2bin($string);

        // Can't handle Ö
        //$func_length = strlen($string);
        //for ($func_index = 0; $func_index < $func_length; ++$func_index) {
        //  $utf8 .= chr(hexdec($string{$func_index} . $string{++$func_index}));
        //}

        // Destroys umlauts
        //    for ($i=0; $i < strlen($string)-1; $i+=2){
        //      $utf8 .= chr(hexdec($string[$i].$string[$i+1]));
        //    }
    }
}
