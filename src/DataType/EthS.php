<?php

namespace Ethereum\DataType;

use Ethereum\RLP\Rlp;


/**
 * String data.
 *
 * @ingroup dataTypesPrimitive
 */
class EthS extends EthBytes
{
    /**
     * @param string $val
     *     A prefixed, ABI Encoded string or a UTF-8 string which does not start with "0x".
     * @param array $params
     * @return null|number|string
     * @throws \InvalidArgumentException
     */
    public function validate($val, array $params)
    {
        $return = null;
        // Decode
        if ($this->hasHexPrefix($val)) {
            // Hex encoded string.
            $return = $this->hexToStr($val);
        }
        else {
            $return = $val;
        }

        // Validate.
        if (is_string((string)$return) && $this->checkUtf8($return)) {
            return $return;
        }
        else {
            throw new \InvalidArgumentException('Can not decode value: ' . $val);
        }
    }


    /**
     * @param $hexVal
     * @return \Ethereum\DataType\EthBytes
     * @throws Exception
     */
    public static function cretateFromRLP($hexVal)
    {
        $rlpItem = Rlp::decode($hexVal);
        return new EthS(self::ensureHexPrefix($rlpItem[0]->get()));
    }

    /**
     * Return hex value.
     *
     * @return string
     *      Prefixed Hex value.
     */
    public function rlpVal()
    {
        // @todo ???
        return Rlp::encode($this->strToHex($this->value));
    }

    /**
     * Get hexadecimal string representation.
     */
    public function hexVal()
    {
        return $this->ensureHexPrefix($this->strToHex($this->value));
    }

    /**
     * @return string
     */
    public function encodedHexVal()
    {
        return $this->rlpVal();
    }

    /**
     * Get string.
     */
    public function val()
    {
        return $this->value;
    }


    /**
     * Verify valid UTF8 string.
     *
     * W3C recommended.
     * @see https://www.w3.org/International/questions/qa-forms-utf-8.en
     *
     * @param $str
     *
     * @return bool
     */
    private function checkUtf8($str)
    {
        if (preg_match('%^(?:
              [\x09\x0A\x0D\x20-\x7E]            # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
            | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
        )*$%xs', $str)) {
            return true;
        }
        return false;
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
        return array_shift($hex);
    }

    /**
     * Converts Hex to string.
     *
     * @see http://perldoc.perl.org/perlpacktut.html
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
        return pack('H*', self::removeHexPrefix($string));
    }

}
