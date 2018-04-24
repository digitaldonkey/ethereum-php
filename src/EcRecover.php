<?php

namespace Ethereum;

use Ethereum\DataType\EthD;
use Ethereum\DataType\EthD32;
use Ethereum\DataType\EthD20;
use Ethereum\DataType\EthQ;

class EcRecover extends EthereumStatic {

  /**
   * PersonalEcRecover function.
   *
   * @param string $message
   *   UTF-8 text without prefix.
   * @param EthD $signature
   *   Hex value of the Message Signature.
   *
   * @return string Ethereum Address
   *
   * @throws \Exception
   *   If keccak hash does not match formal conditions.
   */
  public static function personalEcRecover(string $message, EthD $signature) {
    $message_hash = self::sha3(self::personalSignAddHeader($message));
    $address = self::phpEcRecover(new EthD32($message_hash), $signature);
    return $address;
  }

  /**
   * personalVerifyEcRecover function.
   *
   * @param string $message
   *   UTF-8 text without prefix.
   *
   * @param EthD $signature
   *   Hex value of the Message Signature.
   *
   * @param EthD20 $address
   *   Hex value of the Message Signature.
   *
   * @return bool
   *
   * @throws \Exception
   *   If keccak hash does not match formal conditions.
   */
  public static function personalVerifyEcRecover(string $message, EthD $signature, EthD20 $address) {
    $recovered_address = self::personalEcRecover( $message, $signature);
    return ($address === $recovered_address);
  }

  /**
   * EcRecover - Elliptic Curve Signature Verification.
   *
   * This function ecRecover is a wrapper to a solidity function (ececover).
   * See:
   * http://solidity.readthedocs.io/en/latest/miscellaneous.html?highlight=ecrecover
   *
   * Using this ecRecover-wrapper it is the recommended to use ecrecover in
   * order to  provide future performance improvements.
   *
   * EC recovery doses not require any blockchain interaction, it's just
   * freaky math. Considering libraries, PHP extensions or command
   * line C or node implementations.
   *
   * @param string $message_hash.
   *   Keccak-256 of message in hex
   *
   * @param EthD $signature.
   *   Keccak-256 of message in hex
   *
   * @return string
   *   Keccak256 of the provided string.
   *
   * @throws \Exception
   *   If keccak hash does not match formal conditions.
   */
  public static function phpEcRecover(EthD32 $message_hash, EthD $signature) {
    $return = NULL;

    $sig = self::parseSignature($signature);


    if (!defined('ETHEREUM_ECRECOVER')) {
      define('ETHEREUM_ECRECOVER', '/opt/local/bin/ecrecover #m# #v# #r# #s#');
    }

    // Elliptic Curve recovery
    // Can be implemented in various ways. Currently under investigation.
    // The last option however is using a JsonRPC call.
    if (defined('ETHEREUM_ECRECOVER')) {
      $call = str_replace(
        array('#m#', '#v#', '#r#', '#s#'),
        array($message_hash->hexVal(), $sig['v']->hexVal(), $sig['r']->hexVal(), $sig['s']->hexVal()),
        ETHEREUM_ECRECOVER
      );
      $address = new EthD20(self::ensureHexPrefix(substr(shell_exec($call), 0, 42)));
    }
    else {
      // $address = $this->ecrecovery($message_hash, $v, $r, $s);
      // $this->contractEcRecover($message, EthD $signature, EthD20 $public_key)
      throw new \Exception('EC verifications on contract level is not implemented yet.');
    }

    // Formal verification: Prefix + 64 Hex chars.
    if (!is_a($address, 'Ethereum\DataType\EthD20')) {
      throw new \Exception('ecRecover returns a wrong value.');
    }
    return $address->hexVal();
  }


  /**
   * Contract based EcRecover.
   *
   * @param string $message
   *   UTF-8 text without prefix.
   * @param EthD $signature
   *   Hex value of the Message Signature.
   * @param EthD20 $public_key
   *   Hex version of the Public key (Ethereum Address).
   *
   * @return String Address
   *
   * @throws \Exception
   *   If keccak hash does not match formal conditions.
   */
  public function contractEcRecover($message, EthD $signature, EthD20 $public_key) {
    throw new \Exception('Contract based EcRecovery is not implemented yet.');
  }

  /**
   * Ethereum personal_sign message header.
   *
   * @param string $message
   *   Message to be prefixed.
   *
   * @return string
   *   prefixed message.
   */
  public static function personalSignAddHeader($message) {
    // MUST be double quotes.
    return "\x19Ethereum Signed Message:\n" . strlen($message) . $message;
  }

  /**
   * Parse signature.
   *
   * @param \Ethereum\DataType\EthD $signature
   *   Message to be prefixed.
   *
   * @throws \Exception
   *
   * @return array
   *   Signature as r, s, v parameters to use with ecRecover
   */
  public static function parseSignature(EthD $signature) {

    $r = new EthD32(substr($signature->hexVal(), 0, 66));
    $s = new EthD32(self::ensureHexPrefix(substr($signature->hexVal(), 66, 64)));
    $v = new EthQ(self::ensureHexPrefix(substr($signature->hexVal(), 130, 2)));

    // Parameter v need to be 27 or 28.
    // See: https://ethereum.stackexchange.com/questions/1777/workflow-on-signing-a-string-with-private-key-followed-by-signature-verificatio/1794#1794
    if (!(intval($v->val()) === 27 || intval($v->val()) === 28)) {
      $v = new EthQ($v->val() + 27);
    }
    if (!(intval($v->val()) === 27 || intval($v->val()) === 28)) {
      throw new \Exception('Can not decode v value.');
    }
    return array(
      'r' => $r,
      's' => $s,
      'v' => $v,
    );
  }

}
