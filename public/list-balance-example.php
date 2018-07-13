<?php

use Ethereum\Ethereum;
use Ethereum\DataType\EthBlockParam;
use Ethereum\DataType\EthD20;


/**
 * @var bool IS_PUBLIC Deny public access to this generator.
 */
define('IS_PUBLIC', TRUE);

require_once __DIR__ . '/examples.inc.php';

/**
 * Displays the ethereum status report page.
 *
 * This page provides a overview about Ethereum functions and usage.
 *
 * @param Ethereum $eth Etherum client instance.
 * @return array array of two HTML strings.
 */
function getBalanceAtAddress($address) {

    try {

        $eth = new Ethereum('http://127.0.0.1:7545');
        $balanceInWei = $eth->eth_getBalance(new EthD20($address), new EthBlockParam())->val();
        return $eth->convertCurrency($balanceInWei);

    }
    catch (\Exception $exception) {
        echo "<p style='color: red;'>We have a problem:<br />";
        echo $exception->getMessage() . "</p>";
        echo "<pre>" . $exception->getTraceAsString() . "</pre>";
    }

}


$address = '0x78f444392cB2C0aF3cF606De36Ad080EBf22b500';

printTable([
  0 => ['Address', 'Balance in Ether'],
  1 => [$address, getBalanceAtAddress($address)],
]);
