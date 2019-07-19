<?php

namespace Ethereum;

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
     * @throws \InvalidArgumentException
     *      If signature is not verify able.
     *
     * @return string
     *   Hash of the method signature.
     */
    public static function getMethodSignature($input)
    {

        if (self::isValidFunction($input)) {
            // The signature is 4bytes of the methods keccac hash. E.g: "0x00000000".
            return self::ensureHexPrefix(substr(self::sha3($input), 0, 10));
        }
        else {
            throw new \InvalidArgumentException("No valid (solidity) signature string provided.");
        }
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
     */
    public static function phpKeccak256($string)
    {
        return self::ensureHexPrefix(Keccak::hash($string, 256));
    }

    /**
     * Wrapper to phpKeccak256($string).
     *
     * Ethereum sha3 is not the same as the standardized sha3.
     * @see: https://ethereum.stackexchange.com/questions/30369/difference-between-keccak256-and-sha3
     *
     * As web3js provides a sha3() method we have this wrapper for convenience.
     *
     * @param $string
     *   String to hash.
     *
     * @return string
     *    Hash of input.
     */
    public static function sha3($string)
    {
        return self::phpKeccak256($string);
    }

    /**
     * Is valid function.
     *
     * @todo Pretty basic solidity function verification might need improvement.
     *
     * "The signature is defined as the canonical expression of the basic prototype,
     * i.e. the function name with the parenthesised list of parameter types."
     * @see http://solidity.readthedocs.io/en/develop/abi-spec.html#function-selector
     *
     * This function ignores Aliases.
     *  E.g: test(uint) test(uint256) should both result in 0x29e99f07.
     *  This is intentional. It is not recommended to use short names for function signatures.
     *
     * @param string $input
     *   Function ABI as string.
     *   See: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI.
     *
     * @return bool
     *   True if it is a valid solidity function.
     */
    public static function isValidFunction($input)
    {
        // Check for function and Params.
        // See: https://regex101.com/r/437FZz/4
        $regex = '/^[a-zA-Z]+[a-zA-Z0-9]*[\(]{1}(([\w\d\[\]*){1}(\,[\w\d\[\]]*[\w\d\[\]]*)*)[\)]{1}$/';
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
     * @param bool $throw
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
            return $str;
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
     * Convert from and to ether Ether
     *
     * Defaults from wei to ether.
     *
     * @param float $amount
     * @param string $from
     * @param string $to
     * @throws \Exception
     *
     * @return float
     */
    public static function convertCurrency(float $amount, string $from = 'wei', string $to = 'ether') {

        // relative to Ether
        $convertTabe = [
            'wei' => 1000000000000000000,
            // Kwei, Ada, Femtoether
            'kwei' => 1000000000000000,
            // Mwei, Babbage, Picoether
            'mwei' => 1000000000000,
            // Gwei, Shannon, Nanoether, Nano
            'gwei' => 1000000000,
            // Szabo, Microether,Micro
            'szabo' => 1000000,
            // Finney, Milliether,Milli
            'methere' => 1000,
            'ether' => 1,
            // Kether, Grand,Einstein
            'kether' => 0.001,
            // Kether, Grand,Einstein
            'mether' => 0.000001,
            'gether' => 0.000000001,
            'thether' => 0.000000000001,
        ];
        if (!isset($convertTabe[$from])) {
            throw new \Exception('Inknown currency to convert from "' . $from . '"');
        }
        if (!isset($convertTabe[$to])) {
            throw new \Exception('Inknown currency to convert to "' . $to . '"');
        }
        return $convertTabe[$to] * $amount / $convertTabe[$from];
    }
}
