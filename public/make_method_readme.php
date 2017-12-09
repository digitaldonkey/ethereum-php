<?php

/**
 * @file
 * Generate Doc blocks for the [PHP magic Methods](php.net/manual/en/language.oop5.magic.php) in use.
 *
 * We generating from resources/ethjs-schema.json -> objects.
 *
 * @ingroup generators
 */

use Ethereum\EthDataTypePrimitive;
require_once __DIR__ . '/generator-commons.php';

/**
 * TODO: DOCUMENT THE PHP MAGIC METHODS.
 * This might be a solution, but it would only work in PhpDocumentator.
 * Doxygen refuses to print documentation for functions not defined in code.
 *
 * AND there are some more errors here on array(<type>) returns.
 */

/**
 * @const string TARGET_PATH Generator destination.
 */
define('TARGET_PATH', '../resources/doxygen-assets/EthereumMethods.md');


/**
 * @var bool ACCESS Deny public access to this generator.
 */
define('IS_PUBLIC', TRUE);

/**
 * Better disable access in production.
 */
if (!IS_PUBLIC) {
    header("HTTP/1.1 401 Unauthorized");
    die('ACCESS DENIED');
}

/**
 * @var array $schema Decoded ethjs-schema.
 */
$schema = getSchema();

$data = [
    '<table class="memberdecls">',
    '<tr class="heading"><td colspan="2"><h2 class="groupheader"><a name="pub-methods"></a>Public Member Functions</h2></td></tr>',
    '</table>',
];


foreach ($schema['methods'] as $method_name => $params) {

    // echo "<h3>" . $method_name . "</h3>";

    $class_name = makeClassName($method_name);
    // printMe('Class name base', $class_name);

    $valid_arguments = $params[0];
    $argument_class_names = [];
    if (count($valid_arguments)) {

        // printMe('Valid arguments', $valid_arguments);

        // Get argument definition Classes.
        foreach ($valid_arguments as $type) {
            $primitiveType = EthDataTypePrimitive::typeMap($type);
            if ($primitiveType) {
                $argument_class_names[] = $primitiveType;
            } else {
                $argument_class_names[] = $type;
            }
        }
        // printMe('Valid arguments class names', $argument_class_names);
    }

    $return_type = $params[1];
    // printMe('Return value type', $return_type);

    $data[] = "<h2 class='memtitle'><span class='permalink'>◆&nbsp;</span>$class_name</h2>";
    $data[] = "<div class='memitem'>";

    if (count($valid_arguments)) {


//        <table class="memname">
//        <tbody><tr>
//          <td class="memname">etherRequest </td>
//          <td>(</td>
//          <td class="paramtype">&nbsp;</td>
//          <td class="paramname"><em>$method</em>, </td>
//        </tr>
//        <tr>
//          <td class="paramkey"></td>
//          <td></td>
//          <td class="paramtype">&nbsp;</td>
//          <td class="paramname"><em>$params</em> = <code>[]</code>&nbsp;</td>
//        </tr>
//        <tr>
//          <td></td>
//          <td>)</td>
//          <td></td><td></td>
//        </tr>
//      </tbody></table>

//        $data[] = "<div class='memproto'>";
//        $data[] =    "<table class='memname'><tbody><tr>";
//        $data[] =    "<td class='memname'>$class_name</td>";
//        $data[] =    "<td>(</td>";
//        foreach ($valid_arguments as $i => $param) {
//            $data[] =    "<td class='paramtype'>" . returnType($param) . "</td>";
//            $data[] =    "<td class='paramname'><em>\$$i</em></td>";
//        }
//        $data[] =    "<td>)</td>";
//        $data[] = "</tr></tbody></table>";
//        $data[] = "</div>";
    }

    $data[] = "<div class='memdoc'>";
    $data[] = "[Ethereum Wiki->$method_name](https://github.com/ethereum/wiki/wiki/JSON-RPC#" . strtolower($method_name) . ")";

//    if (count ($valid_arguments)) {
//        $data[] = "<dl class='params'>";
//        $data[] =    "<dt>Parameters</dt>";
//        $data[] =    "<dd>";
//        $data[] =    "<table class='params'><tbody>";
//        foreach ($valid_arguments as $i => $param) {
//            $data[] = "<tr><td class='paramtype'>$param</td><td class='paramname'><em>func_get_args()[$i]</em></td><td></td></tr>";
//        }
//        $data[] =    "</tbody></table>";
//        $data[] =    "</dd>";
//        $data[] = "</dl>";
//    }
//
//    $data[] = "<dl class='section return'><dt>Returns</dt><dd>" . returnType($return_type) . "</dd></dl>";

    $data[] = "</div>"; //.memdoc

    $data[] = "</div>"; // .memitem

    // echo "<hr />";
}


// echo "# Ethereum Methods";
 echo implode("\n", $data);
file_put_contents(TARGET_PATH , implode("\n", $data));
//chmod(TARGET_PATH, 0664);

function returnType($type) {
    if (is_array($type)) {
        // echo "<small>ARRAY TYPE</small> ";
        return returnType($type[0]);
    }
    else if (is_string(EthDataTypePrimitive::typeMap($type))) {
        // echo "<small>SIMPLE TYPE</small> ";
        return EthDataTypePrimitive::typeMap($type);
    }
    if (file_exists(__DIR__ . "/../src/$type.php")) {
        // This should be a complex data type (no Eth prefix).
        // echo "<small>Complex TYPE</small> ";
        return $type;
    }
    else if (strpos($type, '|')) {
        // echo "<small>WEIRED TYPE</small> ";
        // TODO This is actually very weired in the Schema: We have an "or" in Return values.
        // For now we just include both types, but this requires deeper investigation how to handle that.
        $stupid_eth_syncing = "";
        foreach (explode('|', $type) as $t) {
            if (returnType($t)) {
                $stupid_eth_syncing .= returnType($t) . ' or ';
            }
        }
        return substr($stupid_eth_syncing, 0, -4);
    }
    else {
        throw new \Exception('Schema wants a type we do not have');
    }
}
