<?php

namespace Ethereum\RLP;

use Ethereum\DataType\EthQ;
use Ethereum\EthereumStatic;
use InvalidArgumentException;


/**
 * Class Rlp
 *
 * https://github.com/ethereum/wiki/wiki/RLP
 * http://solidity.readthedocs.io/en/develop/abi-spec.html
 *
 * @package Ethereum
 */
class Rlp extends EthereumStatic
{

    //  if a string is 0-55 bytes long, the RLP encoding consists
    // of a single byte with value 0x80 plus the length of the string
    // followed by the string. The range of the first byte is thus [0x80, 0xb7].
    const THRESHOLD_LONG = 110; // As we count hex chars this value is 110
    const PREF_SELF_CONTAINED = 127; // 0x7F
    const OFFSET_SHORT_ITEM = 128; // 0x80
    const OFFSET_LONG_ITEM = 183; // 0xb7;
    const OFFSET_SHORT_LIST = 192; // 0xc0;
    const OFFSET_LONG_LIST = 247; // 0xf7;


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
    public static function encode(string $val)
    {

        $val = self::removeHexPrefix($val);

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
            $lengthInByte = self::getByteLength($length / 2);

        }
        else {
            // If a string is more than 55 bytes long, the RLP encoding
            // consists of a single byte with value 0xb7 plus the length
            // in bytes of the length of the string in binary form, followed
            // by the length of the string, followed by the string.
            $lengthInByte = self::getByteLength($length / 2);
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
    private static function padRight($val)
    {
        $fillUp = 64 - (strlen($val) % 64);
        if ($fillUp < 64) {
            return $val . str_repeat("0", $fillUp);
        }
        return $val;
    }

    /**
     * @param string $hexVal
     *
     * @return \Ethereum\RLP\RlpItem[]
     * @throws \Exception
     */
    public static function decode(string $hexVal): array
    {
        if (!is_string($hexVal) || !strlen($hexVal)) {
            throw new InvalidArgumentException('RLP value length can not be "" or null.');
        }
        $rlpCollection = new RlpCollection();
        $hexVal = self::removeHexPrefix($hexVal);

        // Data length in Chars ?.
        $dataLength = strlen($hexVal);
        self::decodeValues($hexVal, 0, 0, $dataLength, 1, $rlpCollection);
        return $rlpCollection->get();
    }

    /**
     * @param string $msgData
     * @param int $level
     * @param int $startPos
     * @param int $endPos
     * @param int $levelToIndex
     * @param \Ethereum\RLP\RlpCollection $rlpCollection
     * @throws \Exception
     */
    private static function decodeValues(
      string $msgData,
      int $level,
      int $startPos,
      int $endPos,
      int $levelToIndex,
      RlpCollection $rlpCollection
    ) {

        if (is_null($msgData) || strlen($msgData) === 0) {
            // @todo if (msgData == null || msgData.Length == 0)
            $X = false;
            return;
        }

        // var currentData = new byte[endPosition - startPosition];
        // ???? $currentData = substr($msgData, $startPos, $endPos - $startPos);

        $currentPos = $startPos;
        // ???
        // Array.Copy(msgData, startPosition, currentData, 0, currentData.Length);

        try {
            while ($currentPos < $endPos) {

                $prefix = self::getByteValueAtOffsetPos($msgData, $currentPos);

                // Is this sustainable????
                // * Does not work decoding TWO single bytes
                if ($prefix < $currentPos) {
                    break;
                }

                $length = self::getLengthInByte($msgData, $currentPos);

                // prefix <= 0x7f
                if ($prefix <= 127) {

                    $currentPos = self::processSingleByteItem($msgData, $rlpCollection, $currentPos);

                } //  elif prefix <= 0xb7 and length > prefix - 0x80:
                elseif ($prefix <= 183 && $length > $prefix - 128) {
                    // strLen = prefix - 0x80

                    // TODO WHY THERE IS NO DIFFERING PREFIX???

                    $currentPos = self::processSingleByteItem($msgData, $rlpCollection, $currentPos);

                } // prefix <= 0xbf and length > prefix - 0xb7 and length > prefix - 0xb7 + to_integer(substr(input, 1, prefix - 0xb7)):
                elseif ($prefix <= 191 && $length > $prefix - 183 && true) {
                    // lenOfStrLen = prefix - 0xb7
                    // strLen = to_integer(substr(input, 1, lenOfStrLen))
                    // return (1 + lenOfStrLen, strLen, str)
                    $XXX = false;

                    throw new \Exception('Did not run into this yet @Rlp::decodeValues()');

                } // prefix <= 0xf7 and length > prefix - 0xc0:
                elseif ($prefix <= 247 && $length > $prefix - 192) {
                    // listLen = prefix - 192;
                    // return (1, listLen, list)


                    // TODO WHY THERE IS NO DIFFERING PREFIX???

                    $currentPos = self::processSingleByteItem($msgData, $rlpCollection, $currentPos);

                } // prefix <= 0xff and length > prefix - 0xf7 and length > prefix - 0xf7 + to_integer(substr(input, 1, prefix - 0xf7)):
                elseif ($prefix <= 255 && $length > $prefix - 247 && true) {
                    // lenOfListLen = prefix - 0xf7
                    // listLen = to_integer(substr(input, 1, lenOfListLen))
                    // return (1 + lenOfListLen, listLen, list)
                    throw new \Exception('Did not run into this yet @Rlp::decodeValues()');
                }
                else {
                    throw new \Exception('Did not run into this yet @Rlp::decodeValues()');
                }

//          if (self::isOutofBoundary($msgData, $currentPos)) {
//            $XXX = FALSE;
//            break;
//          }
//
//          if (self::isListBiggerThan55Bytes($msgData, $currentPos)) {
//            // $currentPos = ProcessListBiggerThan55Bytes($msgData, level, levelToIndex, rlpCollection, $currentPos);
//            $XXX = FALSE;
////            continue;
//          }
//
//          if (self::isListLessThan55Bytes($msgData, $currentPos)) {
//            // $currentPos = ProcessListLessThan55Bytes($msgData, level, levelToIndex, rlpCollection, $currentPos);
//            $XXX = FALSE;
////            continue;
//          }
//
//          if (self::isItemBiggerThan55Bytes($msgData, $currentPos)) {
//            // $currentPos = ProcessItemBiggerThan55Bytes($msgData, rlpCollection, $currentPos);
//            $XXX = FALSE;
////            continue;
//          }
//
//          if (self::isItemLessThan55Bytes($msgData, $currentPos)) {
//            // $currentPos = ProcessItemLessThan55Bytes($msgData, rlpCollection, $currentPos);
//            $XXX = FALSE;
////            continue;
//          }
//
//          if (self::isNullItem($msgData, $currentPos)) {
//            // $currentPos = ProcessNullItem(rlpCollection, $currentPos);
//            $XXX = FALSE;
////            continue;
//          }
//
//          if (self::isSigleByteItem($msgData, $currentPos)) {
//            // currentPosition = ProcessleBleByteItem(msgData, rlpCollection, currentPosition);
//            $XXX = FALSE;
//            $currentPos = self::processSingleByteItem($msgData,  $rlpCollection, $currentPos);
//          }

            }
        } catch (Exception $e) {
            // "Invalid RLP " + currentData.ToHex(), ex);
            throw new \Exception('Invalid RLP ');
        }
    }


    /**
     * @param string $msgData
     * @param \Ethereum\RLP\RlpCollection $rlpCollection
     * @param int $currentPosgth
     *
     */
    // ProcessSingleByteItem(byte[] msgData, RLPCollection rlpCollection, int currentPosition)
    protected static function processSingleByteItem(
      string $msgData,
      RLPCollection $rlpCollection,
      int $currentPos
    ) {
        $thisData = substr($msgData, $currentPos);
        $item = new RlpItem($thisData);
        $rlpCollection->add($item);
        return $item->getCharLength();
    }


    /**
     * @param $hex
     *    32 bit Integer value.
     * @return int
     */
    private static function byteLength(string $hex)
    {
        return hexdec($hex);
    }

    private static function charLength(string $hex)
    {
        $hex = self::ensureHexPrefix($hex);
        return 2 * hexdec($hex);
    }

    protected static function getByteValueAt(string $msgData, int $pos)
    {
        return self::byteLength(substr($msgData, $pos, 64));
    }


    /**
     * @param string $msgData
     * @param int $pos
     *
     * @return float|int
     */
    protected static function getStringLengthAt(string $msgData, int $pos)
    {
        return self::charLength(substr($msgData, $pos, 64));
    }


    /**
     * ONLY GET THE LAST BYTE
     *
     * @param string $msgData
     * @param int $pos
     *
     * @return int
     */
    public static function getByteValueAtOffsetPos(string $msgData, int $pos)
    {
        if (strlen($msgData) < $pos + 64) {
            throw new \Exception('Not ennough data');
        }
        $lastByte = substr($msgData, $pos + 62, 2);
        return self::byteLength($lastByte);
    }

    /**
     * @deprecated ??
     *
     * @param int $l
     *    Byte length.
     * @return string
     *    uint256 hex value
     * @throws Exception
     */
    protected static function getByteLength(int $l)
    {
        return (new EthQ($l, ['abi' => 'uint256']))->hexVal();
    }


    /**
     * @param string $str
     *
     * @return float|int
     */
    protected static function getLengthInByte(string $str, int $currentPos)
    {
        // (Total length - (Current position + length byte)) / charsPerByte.
        return (strlen($str) - $currentPos + 64) / 2;
    }

    /**
     * @param int $length
     * @return int
     */
    protected static function paddedLength(int $length)
    {
        return $length + 64 - ($length % 64);
    }


    //    protected static function isOutofBoundary(string $msgData, int $currentPos): bool {
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X =  (strlen($msgData) <= $val);
    //      return $X;
    //    }
    //
    //    protected static function isListBiggerThan55Bytes(string $msgData, int $currentPos): bool {
    //      // return msgData[currentPosition] > OFFSET_LONG_LIST;
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X =  ($val > self::OFFSET_LONG_LIST && strlen($msgData) >= $val);
    //      return $X;
    //    }
    //
    //    protected static function isListLessThan55Bytes(string $msgData, int $currentPos): bool {
    //      // return msgData[currentPosition] >= OFFSET_SHORT_LIST && msgData[currentPosition] <= OFFSET_LONG_LIST;
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X = ($val >= self::OFFSET_SHORT_LIST && $val <= self::OFFSET_LONG_LIST);
    //      return $X;
    //    }
    //    protected static function isItemBiggerThan55Bytes(string $msgData, int $currentPos): bool {
    //      //  return msgData[currentPosition] > OFFSET_LONG_ITEM && msgData[currentPosition] < OFFSET_SHORT_LIST;
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X = ($val > self::OFFSET_LONG_ITEM && $val < self::OFFSET_SHORT_LIST);
    //      return $X;
    //    }
    //    protected static function isItemLessThan55Bytes(string $msgData, int $currentPos): bool {
    //      // return msgData[currentPosition] > OFFSET_SHORT_ITEM && msgData[currentPosition] <= OFFSET_LONG_ITEM;
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X = ($val > self::OFFSET_SHORT_ITEM);
    //      return $X;
    //    }
    //    protected static function isNullItem(string $msgData, int $currentPos): bool {
    //      // return msgData[currentPosition] == OFFSET_SHORT_ITEM;
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X = ($val === self::OFFSET_SHORT_ITEM);
    //      return $X;
    //
    //    }
    //    protected static function isSigleByteItem(string $msgData, int $currentPos): bool {
    //      // return msgData[currentPosition] < OFFSET_SHORT_ITEM;
    //      $val = self::getByteValueAtOffsetPos($msgData, $currentPos);
    //      $X = ($val < self::OFFSET_SHORT_ITEM);
    //      return $X;
    //    }
}
