<?php

/**
 * @file
 * Workarounds for specific Ethereum clients.
 *
 * Some client return not exactly what you expect. Hopefully the clients will get fixed and we can remove the workarounds over time.
 */


/**
 * Workaround for eth_protocolVersion().
 *
 * In some cases Ethereum Clients (like geth, parity etc.) have differing
 * return values.
 */

function eth_workaround_eth_protocolVersion($val)
{
    // WORKAROUND: eth_protocolVersion is NULL: Probably testrpc.
    if (is_null($val)) {
        return \Ethereum\EthereumStatic::strToHex('testrpc');
    } else {
        return $val;
    }
}

/**
 * Workaround for eth_coinbase().
 *
 * In some cases Ethereum Clients (like geth, parity etc.) have differing
 * return values.
 */

function eth_workaround_eth_coinbase($val)
{
    // WORKAROUND: Catch a "405 Method Not Allowed'.
    if (isset($val['error']) && $val['error'] && $val['code'] == 405) {
        return '0x0000000000000000000000000000000000000000';
    } else {
        return $val;
    }
}

/**
 * Workaround for net_listening().
 *
 * In some cases Ethereum Clients (like geth, parity etc.) have differing
 * return values.
 */

function eth_workaround_net_listening($val)
{
    // WORKAROUND: eth_protocolVersion is NULL: Probably testrpc.
    if ($val == 'true') {
        return '0x0000000000000000000000000000000000000000000000000000000000000001';
    } else {
        return $val;
    }
}
