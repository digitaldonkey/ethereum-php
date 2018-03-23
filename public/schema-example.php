<?php
/**
 * @file
 *
 * @ingroup examples
 */
use Ethereum\Ethereum;
use Ethereum\DataType\EthDataType;

/**
 * @var bool IS_PUBLIC Deny public access to this generator.
 */
define('IS_PUBLIC', TRUE);

require_once __DIR__ . '/examples.inc.php';

/**
 * @var array $schema Decoded ethjs-schema.
 */
$schema = Ethereum::getDefinition(); /**< array $schema Decoded ethjs-schema. */

echo "<h1>SCHEMA</h1>";

foreach ($schema['methods'] as $fn_name => $params) {

    // $params[0] = Constructor types.
    // $params[1] = Return types.

    echo "<h3>" . $fn_name . "()</h3>";
    echo '<p><small>See Ethereum Wiki <a href="https://github.com/ethereum/wiki/wiki/JSON-RPC#' . strtolower($fn_name) . '">' . $fn_name . '</a></small></p>';
    echo "<h6>params</h6>";

    if (count($params[0])) {
        echo "Arguments in definition: <pre>" . print_r($params[0], true) . "</pre>";

        foreach ($params[0] as $i => $param) {
            echo "<p>Argument $i must use Ethereum data type class: <b>" . EthDataType::getTypeClass($param) . "</b></p>";
        }
    }
    else {
        echo "No arguments";
    }

    echo "<h6>return</h6>";
    echo "Return value in definition: <pre>" . print_r($params[1],1) . "</pre>";
    if (is_array($params[1])) {
        echo "<p>Return is <b>Array</b> of class: <b>" . EthDataType::getTypeClass($params[1][0]) . "</b></p>";
    }
    else {
        echo "<p>Return value will be of class: <b>" . EthDataType::getTypeClass($params[1]) . "</b></p>";
    }
    echo "<hr />";
}
