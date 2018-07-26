<?php

namespace Ethereum\DataType;

/**
 * Byte data, length 32.
 *
 * @ingroup dataTypesPrimitive
 *
 * Represents 64 hex characters, 256 bits. Eg. TX hash.
 */
class EthD32 extends EthD
{
    /**
     * Implement validation.
     *
     * @param string $val
     *   Hexadecimal "0x"prefixed  byte value.
     *
     * @throws \InvalidArgumentException
     *   If things are wrong.
     *
     * @return string
     *   Validated D20 HEX value.
     */
    public function validateLength($val)
    {
        if (strlen($val) <= 66) {
            $padUp = 66 - strlen($val);
            $val = $val . str_repeat('0', $padUp);
        }
        if (strlen($val) === 66) {
            return $val;
        }
        else {
            throw new \InvalidArgumentException('Invalid length for hex binary: ' . $val);
        }
    }

    /**
     * @return string
     */
    public static function getDataLengthType()
    {
        return 'static';
    }

    /**
     * Returns the length in chars according to ABI length.
     *
     * @return int
     */
    protected function getDataStrLength()
    {
        return 2 * preg_replace('/[^0-9]/', '', $this->abi);
    }

    /**
     * Return un-prefixed hex value.
     *
     * Subclasses may return other types.
     *
     * @return string
     *      Un-prefixed Hex value.
     */
    public function val()
    {
        if ($this->abi) {
            // Shortening Data according to ABI lenngth if available.
            return substr($this->value, 2, $this->getDataStrLength());
        }
        // Fall back on full 32 bytes if Abi is not set.
        // It is recommended not to use bytes[1-31], as they all use same space/gas.
        return substr($this->value, 2);
    }
}
