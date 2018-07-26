<?php

namespace Ethereum\DataType;

use Ethereum\RLP\Rlp;

/**
 * Complex Array or byte data.
 *
 * Some Complex types base on EthBytes.
 *
 * @ingroup dataTypesPrimitive
 */
class EthBytes extends EthD
{

    /**
     * Implement validation.
     *
     * @ingroup dataTypesPrimitive
     *
     * @param string $val
     *   0x prefixed ABI encoded value.
     * @param array $params
     *   Only $param['abi'] is relevant.
     *
     * @return string
     *   Unprefixed byte value.
     *
     * @throws \InvalidArgumentException Can not decode int value.
     *   If things are wrong.
     */
    public function validate($val, array $params)
    {
        if (!ctype_xdigit($this->removeHexPrefix($val))) {
            throw new \InvalidArgumentException(
              'Value of dynamic ABI type is not a valid hex string.'
            );
        }
        return $this->ensureHexPrefix($val);
    }

    /**
     * Implement validation.
     *
     * @param string $val
     *   Hexadecimal "0x"prefixed  byte value.
     *
     * @throws InvalidArgumentException
     *
     * @return string
     *   Validated D20 value.
     */
    public function validateLength($val)
    {
        if (strlen($val) % 2 !== 0) {
            throw new \InvalidArgumentException(
              'A valid bytes string must have a even number of letters.'
            );
        } else {
            return $val;
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
        return new EthBytes(self::ensureHexPrefix($rlpItem[0]->get()));
    }

    /**
     * Return hex value.
     *
     * @return string
     *      Prefixed Hex value.
     */
    public function hexVal()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function encodedHexVal()
    {
        return $this->rlpVal();
    }

    /**
     * Return hex value.
     *
     * @return string
     *      Prefixed Hex value.
     */
    public function rlpVal()
    {
        return Rlp::encode($this->value);
    }

    /**
     * Return un-prefixed bin value.
     *
     * Subclasses may return other types.
     *
     * @return string
     *      Un-prefixed Hex value.
     */
    public function val()
    {
        return $this->removeHexPrefix($this->value);
    }

    /**
     * @return string|int
     */
    public static function getDataLengthType()
    {
        return 'dynamic';
    }

}
