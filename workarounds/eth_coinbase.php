<?php

/**
 * Workaround for eth_coinbase().
 *
 * In some cases Ethereum Clients (like geth, parity etc.) have differing
 * return values.
 */

function eth_workaround_eth_coinbase($val) {
  // WORKAROUND: Catch a "405 Method Not Allowed'.
  if (isset($val['error']) && $val['error'] && $val['code'] == 405) {
    return '0x0000000000000000000000000000000000000000';
  }
  else {
    return $val;
  }
}
