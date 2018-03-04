<?php

namespace Ethereum;
use Exception;
use Ethereum\EthS;

/**
 * Static helper functions for Ethereum JsonRPC API for PHP.
 */
abstract class SmartContractStatic
{
  /**
   * Get valid number lengths.
   *
   * @param $abi string
   *    Smart contract ABI json.
   *
   * @return string
   *   Array of valid integer lengths.
   */
  public static function create($abi)
  {


    $XXX = json_decode ($abi , FALSE ,  512 ,  0);

//      try {
//        $eth = new Ethereum($serverUrl);
//
//        // Try to connect.
//        $parsed = $eth->eth_compileSolidity(new EthS($src));
//
//
//        $X = FALSE;
//
//
////        if (!is_string($networkVersion)) {
////          throw new \Exception('eth_protocolVersion return is not valid.');
////        }
////
////        if ($server->network_id !== '*' && $networkVersion !== $server->network_id) {
////          throw new \Exception('Network ID does not match.');
////        }
//      }
//      catch (\Exception $exception) {
//        $return = [
//          'message' => t(
//            "Unable to connect to Server <b>"
//            . $server->label  . "</b><br />"
//            . $exception->getMessage() )
//        ];
//        $return['error'] = TRUE;
//      }


    return '';
  }

}
