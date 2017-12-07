<?php

/**
 * @file
 * Generate Doc blocks for the [PHP magic Methods](php.net/manual/en/language.oop5.magic.php) in use.
 *
 * We generating from resources/ethjs-schema.json -> objects.
 *
 * @ingroup generators
 */


/**
 * TODO: DOCUMENT THE PHP MAGIC METHODS.
 * This might be a solution, but it would only work in PhpDocumentator.
 * Doxygen refuses to print documentation for functions not defined in code.
 *
 * AND there are some more errors here on array(<type>) returns.
 */

/**
 * Better disable access in production.
 */

// Target for generated doc blocks.
define('TARGET_PATH', '../src/helpers/ethMethodsDoc.php');

header("HTTP/1.1 401 Unauthorized");
die('ACCESS DENIED');


use Ethereum\EthDataTypePrimitive;
require_once __DIR__ . '/../vendor/autoload.php';

$schema = json_decode(file_get_contents(__DIR__ . "/../resources/ethjs-schema.json"), true);

$data = [
    "<?php\n\n",
];


foreach ($schema['methods'] as $method_name => $params) {

    echo "<h3>" . $method_name . "</h3>";

    $class_name = makeClassName($method_name);
    printMe('Class name base', $class_name);

    $valid_arguments = $params[0];
    $argument_class_names = [];
    if (count($valid_arguments)) {

        printMe('Valid arguments', $valid_arguments);

        // Get argument definition Classes.
        foreach ($valid_arguments as $type) {
            $primitiveType = EthDataTypePrimitive::typeMap($type);
            if ($primitiveType) {
                $argument_class_names[] = $primitiveType;
            } else {
                $argument_class_names[] = $type;
            }
        }
        printMe('Valid arguments class names', $argument_class_names);
    }

    $return_type = $params[1];
    printMe('Return value type', $return_type);

    $method_data = [
        "/**",
        " * @fn public $return_type $method_name()",
        " * @brief $class_name",
        " * @details See [Ethereum Wiki](https://github.com/ethereum/wiki/wiki/JSON-RPC#" . strtolower($method_name) . ")",
    ];
    foreach ($argument_class_names as $param) {
        $method_data[] = " * @param " . $param;
    }
    $method_data[] = " * @return " . EthDataTypePrimitive::typeMap($return_type);
    $method_data[] = " */\n\n";

    $data = array_merge($data, $method_data);
    echo "<hr />";
}
file_put_contents(TARGET_PATH , implode("\n", $data));
chmod(TARGET_PATH, 0664);


/**
 * Make Class name.
 *
 * @param string $input -
 *                      Method name
 *
 * @return string
 *   Derived Class name.
 */
function makeClassName($input)
{
    $return = '';
    foreach (explode('_', $input) as $part) {
        $return .= ucfirst($part);
    }

    return $return;
}
