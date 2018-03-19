<?php

namespace Ethereum;

use Ethereum\DataType\EthBytes;
use Ethereum\DataType\EthQ;

/**
 * Class Rlp
 *
 * https://github.com/ethereum/wiki/wiki/RLP
 * http://solidity.readthedocs.io/en/develop/abi-spec.html
 *
 * @package Ethereum
 */
class Rlp extends EthereumStatic {

    // const SELF CONTAINED ENCODING  = 127; // 0xb7;
    const PREF_SHORT_ITEM = 128; // 0xc0;
    const PREF_LONG_ITEM = 183; // 0xb7;
    const PREF_SHORT_LIST = 192; // 0xc0;
    const PREF_LONG_LIST = 247; // 0xf7;

    /**
     * Decode RLP Hex argument.
     *
     * @throws
     *
     * @param string $val
     *   Hex string of value.
     *
     * @param $type
     *  Abi type
     */
    public static function decode(string $val) {
        $X = FALSE;

        return self::rlpDecodeLength($val);
    }

    protected static function rlpDecodeLength($hexVal) {

        if (!self::hasHexPrefix($hexVal)) {
            throw new \InvalidArgumentException('rlpDecode requires prefixed hex value.');
        }
        if (!is_string($hexVal) || !strlen($hexVal)) {
            throw new \InvalidArgumentException('RLP value length can not be "" or null.');
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
            $data = self::ensureHexPrefix(substr($hexVal, self::byteToStr(32 + $prefixLength), self::byteToStr($rlpDataLength)));
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
            throw new \Exception('RLP Arrays and lists not implemented');
        }
        if (!$data) {
            // Ensure that we have data in expected length.
            throw new \InvalidArgumentException('RLP invalid length.');
        }
        return $data;
    }


    /**
     * @param $hex
     *    32 bit Integer value.
     * @return int
     */
    private static function byteLength($hex){
        $hex = self::ensureHexPrefix($hex);
        return (new EthQ($hex, ['abi' => 'uint256']))->val();
    }

    private static function byteToStr($length) {
        return 2 * $length;
    }

    /**
     * @param $abiType
     * @throws Exception
     */
    public function convertByAbiArray($abiType)
    {
//        $x = $this->hexVal();
//        $Y = strlen($x);
//        // Min length for RLP in chars
//        // 0x<bytes32 length><value>
//        // 68 = 2 prefix + 64 length + 2 (if length = 1 we still shoud have at least one byte. But it might be "00").
//        if (strlen($this->hexVal()) <= 68) {
//            throw new Exception('Dynamic ABI type "' . $abiType . ' must have minimum length of 33 bytes." .');
//        }
//        self::decodeRLP($abiType);
//        // Decode RLP
//        // @todo Array and complex types.
        throw new Exception('Dynamic ABI type "' . $abiType . '" is not implemented yet.');
    }

}
