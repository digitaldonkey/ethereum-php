<?php

namespace Ethereum\DataType;

use Ethereum\Rlp;
use InvalidArgumentException;

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
     * @throws InvalidArgumentException Can not decode int value.
     *   If things are wrong.
     */
    public function validate($val, array $params)
    {
        // Always assume it's a ABI encoded value.
        // To set bytes plain bytes it has to be done without Hex prefix.
        if (isset($params['abi'])) {
            $val = Rlp::decode($val);
        }

        if (self::hasHexPrefix($val)) {
            $val = Rlp::decode($val);
        }

        if (!ctype_xdigit($val)) {
            throw new InvalidArgumentException(
                'Value of dynamic ABI type is not a valid hex string.'
            );
        }
        return $val;
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
        if (strlen($val) % 2 !== 0) {
            throw new \InvalidArgumentException(
                'A valid bytes string must have a even number of letters.'
            );
        }
        else {
            return $val;
        }
    }

    /**
     * Return hex value.
     *
     * @return string
     *      Prefixed Hex value.
     */
    public function hexVal()
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
        return $this->value;
    }

}
