<?php

namespace Ethereum;

use Behat\Mink\Exception\Exception;
//use \Moontoast\Math\BigNumber as BigNumber;
use Math_BigInteger as Integer;

/**
 * Static helper functions for Ethereum JsonRPC API for PHP.
 */
class EthereumStatic {

  /**
   * ENCODE a HEX.
   *
   * See:
   * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
   *
   * @param string|int $input
   *   Value to be hex encoded.
   *
   * @return string
   *   Encoded integer or String value.
   */
  public static function encodeHex($input) {

    if (is_numeric($input)) {
      $hex_str = EthereumStatic::large_dechex($input);
    }
    elseif (is_string($input)) {
      $hex_str = EthereumStatic::strToHex($input);
    }
    else {
      throw new \InvalidArgumentException($input . ' is not a string or number.');
    }
    return '0x' . $hex_str;
  }

  /**
   * Decodes a HEX encoded number.
   *
   * See:
   * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
   *
   * Problem: signed values
   * Ethereum uses the "two's complement signed integer"
   * where -1 === PHP_INT_MAX (32/64 bits depending on system).
   * See: https://en.wikipedia.org/wiki/Two%27s_complement
   *
   * Read about the challenges in PHP implementation:
   * https://devzone.zend.com/3443/phps-remarkable-hexadecimals.
   *
   *
   * @param string $input
   *   String convert to number.
   *
   * @throws \InvalidArgumentException
   *   If the provided argument not a HEX number.
   *
   * @return int
   *   Decoded number.
   */
  public static function decodeHexNumber($input) {

    if (!EthereumStatic::isValidHexQuantity($input)) {
      throw new \InvalidArgumentException($input . ' is not a valid quantity.');
    }
    $hex_number = self::removeHexPrefix($input);

    // Large Integer?
    // How may bits?
    // http://stackoverflow.com/questions/16124059/trying-to-read-a-twos-complement-16bit-into-a-signed-decimal

    die ('TODO');

    $dec = 0;
    $len = strlen($hex_number);
    for ($i = 1; $i <= $len; $i++) {
      $dec = bcadd($dec, bcmul(strval(hexdec($hex_number[$i - 1])), bcpow('16', strval($len - $i))));
    }
    $dec = (float) $dec;
    return $dec;
  }

  /**
   * Tests string for valid hex quantity.
   *
   * See:
   * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
   *
   * @param string $str
   *   String to test for Hex.
   *
   * @return bool
   *   TRUE if string is a Valid Hex value or FALSE.
   */
  public static function isValidHexQuantity($str) {

    // Always ensure 0x prefix.
    if (!EthereumStatic::hasHexPrefix($str)) {
      return FALSE;
    }

    // Should always have at least one digit - zero is "0x0".
    if (strlen($str) < 3) {
      return FALSE;
    }
    return ctype_xdigit(self::removeHexPrefix($str));
  }

  /**
   * Tests if the given string is a HEX UNFORMATED DATA value.
   *
   * See:
   * https://github.com/ethereum/wiki/wiki/JSON-RPC#hex-value-encoding.
   *
   * @param string $str
   *   String to test for Hex.
   *
   * @return bool
   *   TRUE if string is a Valid Hex value or FALSE.
   */
  public function isValidHexData($str) {

    // Always ensure 0x prefix.
    if (!EthereumStatic::hasHexPrefix($str)) {
      return FALSE;
    }
    // Should always have at least one digit - zero is "0x0".
    if (strlen($str) <= 3) {
      return FALSE;
    }

    // Ensure two hex digits per byte.
    if ((strlen($str) % 2 != 0)) {
      return FALSE;
    }
    return ctype_xdigit(self::removeHexPrefix($str));
  }

  /**
   * Check for a valid Ethereum address.
   *
   * Tests if the given string qualifies as a Ethereum address.
   * (DATA, 20 Bytes - address)
   *
   * @param string $address
   *   String to test for Address.
   * @param bool $throw
   *   If TRUE we will throw en error.
   *
   * @return bool
   *   TRUE if string is a Valid Address value or FALSE.
   */
  public static function isValidAddress($address, $throw = FALSE) {

    if (!self::hasHexPrefix($address)) {
      return FALSE;
    }
    // Address should be 20bytes=40 HEX-chars + prefix.
    if (strlen($address) !== 42) {
      return FALSE;
    }
    $return = ctype_xdigit(self::removeHexPrefix($address));

    if (!$return && $throw) {
      throw new \InvalidArgumentException($address . ' has invalid format.');
    }
    return $return;
  }

  /**
   * Test if a string is prefixed with "0x".
   *
   * @param string $str
   *   String to test prefix.
   *
   * @return bool
   *   TRUE if string has "0x" prefix or FALSE.
   */
  public static function hasHexPrefix($str) {
    return substr($str, 0, 2) === '0x';
  }

  /**
   * Remove Hex Prefix "0x".
   *
   * @param string $str
   *   String with prefix.
   *
   * @return string
   *   String without prefix.
   */
  public static function removeHexPrefix($str) {
    if (!self::hasHexPrefix($str)) {
      throw new \InvalidArgumentException('String is not prefixed with "0x".');
    }
    return substr($str, 2);
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
  public static function strToHex($string) {
    $hex = unpack('H*', $string);
    return '0x' . array_shift($hex);
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
   * @throws \Exception
   *   If string is not a formally valid address.
   */
  public static function hexToAddress($string) {

    if (!self::hasHexPrefix($string)) {
      $string = '0x' . $string;
    }
    // Remove leading zeros.
    // See: https://regex101.com/r/O2Rpei/1
    $matches = array();
    if (preg_match('/^0x[0]*([1-9,a-f][0-9,a-f]*)$/is', $string, $matches)) {
      $address = '0x' . $matches[1];
      // Throws an Exception if not valid.
      if (self::isValidAddress($address, TRUE)) {
        return $address;
      }
    }
    return NULL;
  }

  /**
   * Converts Hex to string.
   *
   * @param string $string
   *   Hex string to be converted to UTF-8.
   *
   * @return string
   *   String value.
   *
   * @throws \Exception
   */
  public static function hexToStr($string) {

    if (!self::hasHexPrefix($string)) {
      throw new \Exception('String is missing Hex prefix "0x" : ' . $string);
    }
    $string = substr($string, strlen('0x'));
    $utf8 = '';


    $letters = str_split($string, 2);
    foreach ($letters as $letter) {
      $utf8 .= html_entity_decode("&#x$letter;", ENT_QUOTES, 'UTF-8');
    }
    return $utf8;

    // Dosn't tackle Line 18
    // if ($string < 128) {
    //   $utf = chr($string);
    // }
    // elseif ($string < 2048) {
    //   $utf = chr(192 + (($string - ($string % 64)) / 64));
    //   $utf .= chr(128 + ($string % 64));
    // }
    // else {
    //  $utf = chr(224 + (($string - ($string % 4096)) / 4096));
    //  $utf .= chr(128 + ((($string % 4096) - ($string % 64)) / 64));
    //  $utf .= chr(128 + ($string % 64));
    //}

    // Can't handle Ö
    // $utf8 = hex2bin($string);

    // Can't handle Ö
    //$func_length = strlen($string);
    //for ($func_index = 0; $func_index < $func_length; ++$func_index) {
    //  $utf8 .= chr(hexdec($string{$func_index} . $string{++$func_index}));
    //}

    // Destroys umlauts
    //    for ($i=0; $i < strlen($string)-1; $i+=2){
    //      $utf8 .= chr(hexdec($string[$i].$string[$i+1]));
    //    }
  }

//  /**
//   * Converts float number to Hex.
//   *
//   * @param float $dec
//   *   Float umber to be converted to HEX.
//   *
//   * @return string
//   *   String with hexadecimal representation.
//   */
//  public static function large_dechex($dec) {
//
//    // Convert Float to "large integer".
//
////    $uuid = BigNumber::convertToBase10($dec, 10);
//
//    $bn = new BigNumber($dec);
//
////    var_dump($bn->getValue());
////    var_dump($bn->convertToBase(16));
////
////    //    $dec = sprintf('%.0f', $dec);
////    //$dec = bcmod("$x", $dec);
////    var_dump($dec);
//
//    $hex = '';
//    do {
//      $last = bcmod($dec, 16);
//      $hex = dechex($last).$hex;
//      $dec = bcdiv(bcsub($dec, $last), 16);
//    } while($dec>0);
//    return $hex;
//  }

}
