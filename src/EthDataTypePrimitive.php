<?php


/**
 * Basic Ethereum data types.
 *
 * @see: https://github.com/ethereum/wiki/wiki/Ethereum-Contract-ABI#types
 */
class EthDataTypePrimitive extends EthDataType {

  /**
   * @var EthereumData$value
   */
  protected $value;

  const map = array(
    // Bytes data.
    'D' => 'EthD',
    // Bytes data, length 20
    //   40 hex characters, 160 bits. E.g Ethereum Address.
    'D20' => 'EthD20',
    // Bytes data, length 32
    //   64 hex characters, 256 bits. Eg. TX hash.
    'D32' => 'EthD32',
    // Number quantity.
    'Q' => 'EthQ',
    // Boolean.
    'B' => 'EthB',
    // String data
    'S' => 'EthS',
    // Default block parameter: Address (D20) or tag [latest|earliest|pending].
    'Q|T' => 'EthBlockParam',
    // Either an array of DATA or a single bytes DATA with variable length.
    'Array|DATA' => 'EthData',
  );

  public function setValue($val){

    // TODO IMPLEMENT VALIDATE
    $this->value = $val;
  }
}
