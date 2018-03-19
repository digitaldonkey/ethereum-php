<?php

namespace Ethereum\DataType;

use Ethereum\Rlp;

/**
 * Complex Array or byte data.
 *
 * Some Complex types base on EthData.
 *
 * @ingroup dataTypesPrimitive
 */
class EthData extends EthD
{
    /**
     * @var $length
     *  byte length (1 byte = 2 hex chars).
     */
    private $length;


    /**
     * @var $offset
     *  byte offset (1 byte = 2 hex chars).
     */
    private $offset;

    /**
     * @const HEADER_LENGTH
     *  string length of the length prefix.
     *  We will have 0x<bytes32 length>
     */
    const HEADER_LENGTH = 66;




    /**
     * Implement validation.
     *
     * @ingroup ?????????
     *
     * @param string|number $val // todo Hexval only?
     *   "0x"prefixed hexadecimal or number value.
     * @param array         $params
     *   Only $param['abi'] is relevant.
     *
     * @throw InvalidArgumentException Can not decode int value.
     *   If things are wrong.
     */
    public function validate($val, array $params)
    {
        $decodedVal = Rlp::decode($val);

        $X = FALSE;
        // TODO implement validation
        // setValue() might be taking an (statically constructable)
        //      HexString
        //      array($hexVal, $length, $offset)
        // or
        // Drop the offset (we'll get it back in encode)
        // Just save the sting and the length
        // validate the length?!

        return $decodedVal;
    }

    /**
     * Implement validation.
     *
     * @param string $val
     *   Hexadecimal "0x"prefixed  byte value.
     *
     * @throw Exception
     *   If things are wrong.
     *
     * @return string
     *   Validated D20 value.
     */
    public function validateLength($val)
    {

        //  bytes: dynamic sized byte sequence.
        //  string: dynamic sized unicode string assumed to be UTF-8 encoded.
        // Assume Dynamic Offset = 0


        // Min length for RLP in chars
        // 0x<bytes32 length><value>
        // 68 = 2 prefix + 64 length + 2 (if length = 1 we still shoud have at least one byte. But it might be "00").
        $lengthHexVal = substr($val, 0, self::HEADER_LENGTH);

        // Definition: len(a) is the number of bytes in a binary string a.
        // The type of len(a) is assumed to be uint256.
        $byteLength = (new EthQ($lengthHexVal, ['abi' => 'uint256']))->val();
        $this->length = $byteLength;

//        $offset = self::charLengthOffset ($val);


        // Length + right padded to 32bit.
        $paramLength = $this->charLengthWithPadding();
        $charLengthOfVal = strlen($val);
        if ($charLengthOfVal === $paramLength) {
            return $val;
        }
        else {
            throw new \InvalidArgumentException(
                // TODO ABI TYPE?
                'Value of dynamic ABI type "'  . ' with ' . $byteLength
                . ' data must be exactly ' . $this->charLengthWithPadding () . ' hex cars to be valid.'
            );
        }

    }

    /**
     * @return int
     *      Hex-string length of a RLP encoded value.
     */
    private function charLengthWithPadding () {
        $byteLength = $this->length;
//        if ($byteLength <= 32) {
//            $byteLength = 32;
//        }
//        else {
//            $pad = $byteLength % 32;
//        }
        $header = self::HEADER_LENGTH;
        $b = 4 * $byteLength; // bytes -> strlen.
        $ret = $header + $b;
        return $ret;
    }

    /**
     * @return int
     *      Hex-string length of a RLP encoded value.
     */
    private function charLengthOffset ($val) {
        $header = self::HEADER_LENGTH;

        $offset = substr($val, self::HEADER_LENGTH , 64);
        $offsetNumber = (new EthQ($offset, ['abi' => 'uint256']))->val();
        return $offsetNumber;
    }


    protected static function rlpDecode($val, $type) {

    }

    protected static function rlpDecodeLength($hexVal) {

        $length = strlen($hexVal);

        if (!self::hasHexPrefix($hexVal)) {
            throw new \InvalidArgumentException('rlpDecode requires prefixed hex value.');
        }
        if (!$length) {
            throw new \InvalidArgumentException('RLP value length can not be "" or null.');
        }

        // Let's check the first 32bit for a value.

        $prefix = (new EthQ(substr($hexVal, 0, 66)))->val(); // e.g. 0x7f=127
        if ($prefix <= 127) {
            //  (offset, dataLen, type) return (0, 1, str)
            // The value is himself type byte or string.
            $X = false;
        }
        elseif ($prefix <= 183) {
            // string or byte > bytes32
            $X = substr_replace($hexVal, '00', 2,2);
            $myLength = (new EthQ($X))->val(); // e.g. 0x7f=127

        }
        else {
            throw new \InvalidArgumentException('List values are not implemented.');
        }
    }
}
