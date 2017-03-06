<?php

namespace Ethereum;

/**
 * Byte data, length 32.
 *
 * Represents 64 hex characters, 256 bits. Eg. TX hash.
 */
class EthD32 extends EthD {

  /**
   * Implement validation.
   *
   * @param string $val
   *   Hexadecimal "0x"prefixed  byte value.
   *
   * @throws \Exception
   *   If things are wrong.
   *
   * @return string
   *   Validated D20 value.
   */
  public function validateLength($val) {

    if (strlen($val) === 66) {
      return $val;
    }
    else {
      throw new \InvalidArgumentException('Invalid length for hex binary: ' . $val);
    }
  }

}
