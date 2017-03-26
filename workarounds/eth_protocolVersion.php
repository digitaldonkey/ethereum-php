<?php

/**
 * Workaround for eth_protocolVersion().
 *
 * In some cases Ethereum Clients (like geth, parity etc.) have differing
 * return values.
 */

function eth_workaround_eth_protocolVersion($val) {
  // WORKAROUND: eth_protocolVersion is NULL: Probably testrpc.
  if (is_null($val)) {
    return \Ethereum\EthereumStatic::strToHex('testrpc');
  }
  else {
    return $val;
  }
}
