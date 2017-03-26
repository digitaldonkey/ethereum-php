<?php

/**
 * Workaround for net_listening().
 *
 * In some cases Ethereum Clients (like geth, parity etc.) have differing
 * return values.
 */

function eth_workaround_net_listening($val) {
  // WORKAROUND: eth_protocolVersion is NULL: Probably testrpc.
  if ($val == 'true') {
    return '0x0000000000000000000000000000000000000000000000000000000000000001';
  }
  else {
    return $val;
  }
}
