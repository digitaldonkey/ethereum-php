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
     * @throw Exception
     *   If things are wrong.
     *
     * @return string
     *   Validated D20 HEX value.
     */
    public function validateLength($val)
    {
      if (strlen($val) <= 66) {
        $padUp = 66 - strlen($val);
        $val = $val . str_repeat ( '0' , $padUp );
      }
      if (strlen($val) === 66) {
          return $val;
      } else {
          throw new \InvalidArgumentException('Invalid length for hex binary: ' . $val);
      }
    }
}
