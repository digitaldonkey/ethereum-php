<?php

namespace Ethereum\DataType;

use Ethereum\DataType\EthQ;

/**
 * Byte data, length 20.
 *
 * @ingroup dataTypesPrimitive
 *
 * Represents 40 hex characters, 160 bits. E.g Ethereum Address.
 */
class EthD20 extends EthD
{
    /**
     * Implement validation.
     *
     * @param string $val
     *   Hexadecimal "0x"prefixed  byte value.
     *
     * @throws Exception
     *   If things are wrong.
     *
     * @return string
     *   Validated D20 value.
     */
    public function validateLength($val)
    {
        $un_padded = $this->unPadEnsureLength($val);
        if ($un_padded) {
            return $un_padded;
        } else {
            throw new \InvalidArgumentException('Invalid length for hex binary: ' . $val);
        }
    }

    /**
     * Converts Hex to string.
     *
     * @param string $string
     *   Hex string to be converted.
     *
     * @return string
     *   If address can't be decoded.
     *
     * @throws Exception
     *   If string is not a formally valid address.
     */
    public static function unPadEnsureLength($string)
    {

        // Remove leading zeros.
        // See: https://regex101.com/r/O2Rpei/5
        $matches = [];
        if (preg_match('/^0x0*([0-9,a-f]{40})$/is', self::ensureHexPrefix($string), $matches)) {
            $address = '0x' . $matches[1];
            // Throws an Exception if not valid.
            if (self::isValidAddress($address, true)) {
                return $address;
            }
        }
        return null;
    }

  /**
   * Checks if address is not null.
   *
   * @return bool
   */
    public function isNotNull() {
        $checkForValue = new EthQ($this->value);
        return $checkForValue->isNotNull();
    }

    /**
    * @return string|int
    */
    public static function getDataLengthType()
    {
        return 'static';
    }

}
