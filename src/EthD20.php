<?php

namespace Ethereum;

/**
 * Byte data, length 20.
 *
 * Represents 40 hex characters, 160 bits. E.g Ethereum Address.
 */
class EthD20 extends EthD {

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

    if (strlen($val) === 42) {
      return $val;
    }
    else {
      throw new \InvalidArgumentException('Invalid length for hex binary: ' . $val);
    }
  }

}
