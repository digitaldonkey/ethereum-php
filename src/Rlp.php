<?php

namespace Ethereum;

use Ethereum\DataType\EthBytes;
use Ethereum\DataType\EthQ;
use InvalidArgumentException;

/**
 * Class Rlp
 *
 * https://github.com/ethereum/wiki/wiki/RLP
 * http://solidity.readthedocs.io/en/develop/abi-spec.html
 *
 * @package Ethereum
 */
class Rlp extends EthereumStatic {

    //  if a string is 0-55 bytes long, the RLP encoding consists
    // of a single byte with value 0x80 plus the length of the string
    // followed by the string. The range of the first byte is thus [0x80, 0xb7].
    const THRESHOLD_LONG = 110; // As we count hex chars this value is 110
    // const SELF CONTAINED ENCODING  = 127; // 0xb7;
    const PREF_SHORT_ITEM = 128; // 0xc0;
    const PREF_LONG_ITEM = 183; // 0xb7;
    const PREF_SHORT_LIST = 192; // 0xc0;
    const PREF_LONG_LIST = 247; // 0xf7;


    /**
     * Enecode RLP Hex argument.
     *
     * @param string $val
     *   Hex string of value.
     *
     * @return string
     *   Hex string. Encoded byte value with RLP prefixes.
     *
     * @throws
     */
    public static function encode(string $val) {

        // Length in chars. Note: 2 chars equals one hex byte.
        $length = strlen($val);

        // Offset where the value (the length byte actually) starts. This is only relevant
        // in Arrays and lists which are not yet implemented.
        $offset = '0x0000000000000000000000000000000000000000000000000000000000000020';

        if ($length % 2 && ctype_xdigit($val)) {
            throw new InvalidArgumentException('Can not decode. Invalid hex value.');
        }

        if ($length < self::THRESHOLD_LONG) {
            // if a string is 0-55 bytes long, the RLP encoding consists
            // of a single byte with value 0x80 plus the length of the
            // string followed by the string. The range of the first byte is thus [0x80, 0xb7].
            $lengthInByte = self::getByteLength($length/2);

        }
        else {
            // If a string is more than 55 bytes long, the RLP encoding
            // consists of a single byte with value 0xb7 plus the length
            // in bytes of the length of the string in binary form, followed
            // by the length of the string, followed by the string.
            $lengthInByte = self::getByteLength($length/2);
        }

        return $offset . self::removeHexPrefix($lengthInByte) . self::padRight($val);
    }

    /**
     * Fill with zeros.
     *
     * @param $val string
     *   Arbitrary length hex string.
     * @return string
     *   Value padded with "0" to the right till we match multiples of 32 byte (64 chars).
     */
    private static function padRight($val) {
        $fillUp = 64 - (strlen($val) % 64);
        if ($fillUp < 64) {
            return $val . str_repeat ("0" ,$fillUp);
        }
        return $val;
    }

    /**
     * Decode RLP Hex argument.
     *
     * @throws
     *
     * @param string $hexVal
     *   Hex string of value.
     *
     * @return string
     *   Hex string. Encoded byte value without RLP prefixes.
     */
    public static function decode(string $hexVal) {
        if (!self::hasHexPrefix($hexVal)) {
            throw new InvalidArgumentException('rlpDecode requires prefixed hex value.');
        }
        if (!is_string($hexVal) || !strlen($hexVal)) {
            throw new InvalidArgumentException('RLP value length can not be "" or null.');
        }

        // Remove prefix for easier arithmetic.
        $hexVal = self::removeHexPrefix($hexVal);

        $hexValLength = strlen($hexVal);

        $prefix = substr($hexVal, 0, 64);
        $prefixLength = self::byteLength($prefix);

        $secondByte = substr($hexVal, 64, 64);
        $rlpDataLength = self::byteLength($secondByte);

        if ($prefixLength < self::PREF_SHORT_ITEM) {
            //  (offset, dataLen, type) return (0, 1, str)
            // The value is himself type byte or string.
            $data = substr($hexVal, self::byteToStr(32 + $prefixLength), self::byteToStr($rlpDataLength));
        }
        elseif (
            $rlpDataLength < self::PREF_LONG_ITEM
            && $hexValLength > ($prefixLength - self::PREF_SHORT_ITEM)
        ) {
            // prefix <= 0xb7 and length > prefix - 0x80
            $prefixLength = self::PREF_SHORT_ITEM;
            $rlpDataLength = self::byteToStr($rlpDataLength);
            $data = self::ensureHexPrefix(substr($hexVal, $prefixLength, $rlpDataLength));
        }
        else {
            // $data = self::ensureHexPrefix(substr($hexVal, self::byteToStr(32 + $prefixLength), self::byteToStr($rlpDataLength)));
            throw new InvalidArgumentException('RLP Arrays and lists not implemented');
        }
        if (!$data) {
            // Ensure that we have data in expected length.
            throw new InvalidArgumentException('RLP invalid length.');
        }
        return $data;
    }


    /**
     * @param $hex
     *    32 bit Integer value.
     * @return int
     */
    private static function byteLength(string $hex){
        $hex = self::ensureHexPrefix($hex);
        return (new EthQ($hex, ['abi' => 'uint256']))->val();
    }

    /**
     * @param int $l
     *    Byte length.
     * @return string
     *    uint256 hex value
     * @throws \Exception
     */
    private static function getByteLength(int $l) {
        return (new EthQ($l, ['abi' => 'uint256']))->hexVal();
    }

    /**
     * @param integer $length
     * @return int
     */
    private static function byteToStr(int $length) {
        return 2 * $length;
    }

}
