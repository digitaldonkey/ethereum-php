<?php
/**
 * @file
 * Some legacy to review.
 *
 * @ingroup tests
 */

/**
 * @var bool ACCESS Deny public access to this generator.
 */
define('IS_PUBLIC', FALSE);

/**
 * Better disable access in production.
 */
if (!IS_PUBLIC) {
    header("HTTP/1.1 401 Unauthorized");
    die('ACCESS DENIED');
}

use Ethereum\EthBlockParam;
use Ethereum\EthD32;
use Ethereum\EthQ;
use Ethereum\Filter;
use Ethereum\Transaction;

require_once __DIR__ . '/../vendor/autoload.php';

$quantity = new EthQ('0x0000000000000000000000000000001');
printMe ('Setting and getting 1 at EthQ()', $quantity->hexVal());


$block = new EthBlockParam('0xe4c2c112df6f03cd629ab5e66792b7a4b86a64c3971c0e24764d3e9f68f7cd64');

$filter = new Filter($block);

// This should throw an InvalidArgumentException:
// $X->set('fromBlock', 'hello');

printMe ('Filter toArray()', $filter->toArray());


$hash = new EthD32('0xe4c2c112df6f03cd629ab5e66792b7a4b86a64c3971c0e24764d3e9f68f7cd64');
$tx = new Transaction($hash);

printMe ('Transaction toArray()', $tx->toArray());
