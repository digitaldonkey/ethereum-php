<?php

use Ethereum\Ethereum;
use Ethereum\DataType\EthBlockParam;
use Ethereum\DataType\EthB;
use Ethereum\DataType\EthS;

/**
 * @var bool IS_PUBLIC Deny public access to this generator.
 */
define('IS_PUBLIC', TRUE);

require_once __DIR__ . '/examples.inc.php';

/**
 * @var array $hosts Iterate over multiple hosts.
 */
$hosts = [
    // Start testrpc, geth or parity locally.
    'http://localhost:7545',
    // This is a demo-only purpose account only.
    // Register your own access token. It's free!
    // https://infura.io/#how-to
    'https://kovan.infura.io/drupal'
];

foreach($hosts as $url)
{
    try {
        echo "<h3>What's up on $url</h3>";
        $eth = new Ethereum($url);
        printTable(status($eth));

    }
    catch (\Exception $exception) {
        echo "<p style='color: red;'>We have a problem:<br />";
        echo $exception->getMessage() . "</p>";
        echo "<pre>" . $exception->getTraceAsString() . "</pre>";
    }
    echo "<hr />";

}

/**
 * Displays the ethereum status report page.
 *
 * This page provides a overview about Ethereum functions and usage.
 *
 * @param Ethereum $eth Etherum client instance.
 * @return array array of two HTML strings.
 */
function status($eth) {
    $rows = [];

    $rows[] = ['<b>JsonRPC standard Methods</b>', 'Read more about <a href="https://github.com/ethereum/wiki/wiki/JSON-RPC">Ethereum JsonRPC-API</a> implementation.'];
    $rows[] = ["Client version (web3_clientVersion)", $eth->web3_clientVersion()->val()];
    $rows[] = ["Listening (net_listening)", $eth->net_listening()->val() ? '✔' : '✘'];
    $rows[] = ["Peers (net_peerCount)", $eth->net_peerCount()->val()];
    $rows[] = ["Protocol version (eth_protocolVersion)", $eth->eth_protocolVersion()->val()];
    $rows[] = ["Network version (net_version)", $eth->net_version()->val()];
    $rows[] = ["Syncing (eth_syncing)", $eth->eth_syncing()->val() ? '✔' : '✘'];

    // Mining and Hashrate.
    $rows[] = ["Mining (eth_mining)", $eth->eth_mining()->val() ? '✔' : '✘'];

    $hash_rate = $eth->eth_hashrate();
    $mining = is_a($hash_rate, 'EthQ') ? ((int) ($hash_rate->val() / 1000) . ' KH/s') : '✘';
    $rows[] = ["Mining hashrate (eth_hashrate)", $mining];

    // Gas price is returned in WEI. See: http://ether.fund/tool/converter.
    $price = $eth->eth_gasPrice()->val();
    $price = $price . 'wei ( ≡ ' . number_format(($price / 1000000000000000000), 8, '.', '') . ' Ether)';
    $rows[] = ["Current price per gas in wei (eth_gasPrice)", $price];

    // Blocks.
    $rows[] = ["<b>Block info</b>", ''];
    $block_latest = $eth->eth_getBlockByNumber(new EthBlockParam('latest'), new EthB(FALSE));
    $rows[] = [
        "Latest block age",
        date(DATE_RFC850, $block_latest->getProperty('timestamp')),
    ];

    // Testing_only.

    $block_earliest = $eth->eth_getBlockByNumber(new EthBlockParam(1), new EthB(FALSE));
    $rows[] = [
        "Age of block number '1' <br/><small>The 'earliest' block has no timestamp on many networks.</small>",
        $block_earliest->getProperty('timestamp'),
    ];
    $rows[] = [
        "Client first (eth_getBlockByNumber('earliest'))",
        '<div style="max-width: 800px; max-height: 120px; overflow: scroll">' . $eth->debug('', $block_earliest) . '</div>',
    ];

    // Second param will return TX hashes instead of full TX.
    $block_latest = $eth->eth_getBlockByNumber(new EthBlockParam('earliest'), new EthB(FALSE));
    $rows[] = [
        "Client first (eth_getBlockByNumber('latest'))",
        '<div style="max-width: 800px; max-height: 120px; overflow: scroll">' . $eth->debug('', $block_latest) . '</div>',
    ];
    $rows[] = [
        "Uncles of latest block",
        '<div style="max-width: 800px; max-height: 120px; overflow: scroll">' . $eth->debug('', $block_latest->getProperty('uncles')) . '</div>',
    ];

    $high_block = $eth->eth_getBlockByNumber(new EthBlockParam(999999999), new EthB(FALSE));
    $rows[] = [
        "Get hash of a high block number<br /><small>Might be empty</small>",
        $high_block->getProperty('hash'),
    ];


    // Accounts.
    $rows[] = ["<b>Accounts info</b>", ''];
    $coin_base = $eth->eth_coinbase()->hexVal();
    if ($coin_base === '0x0000000000000000000000000000000000000000') {
        $coin_base = 'No coinbase available at this network node.';
    }

    $rows[] = ["Coinbase (eth_coinbase)", $coin_base];
    $address = ['No accounts available.'];
    $accounts = $eth->eth_accounts();
    if (count($accounts)) {
        $address = [];
        foreach ($eth->eth_accounts() as $addr) {
            $address[] = $addr->hexVal();
        }
    }
    $rows[] = ["Accounts (eth_accounts)", implode(', ', $address)];

    // More.
    $rows[] = [
        "web3_sha3('Hello World')",
        // Using the API would be: $eth->web3_sha3(new EthS('Hello World'))->hexVal(),
        $eth->sha3('Hello World'),
    ];

    // NON standard JsonRPC-API Methods below.
    $rows[] = ['<b>Non standard methods</b>', 'PHP Ethereum controller API provides additional methods. They are part of the <a href="https://github.com/digitaldonkey/ethereum-php">Ethereum PHP library</a>, but not part of JsonRPC-API standard.'];

    $rows[] = ["getMethodSignature('validateUserByHash(bytes32)')", $eth->getMethodSignature('validateUserByHash(bytes32)')];

    return $rows;
}
