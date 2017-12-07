<?php

/**
 * @file
 * Generate Method tests.
 *
 * We generating from resources/ethjs-schema.json -> objects.
 *
 * @ingroup generators
 */


/**
 * Actually this is not working. Just leave it for reference.
 */
// header("HTTP/1.1 401 Unauthorized");
// die('ACCESS DENIED');

use Ethereum\EthDataTypePrimitive;

define('TARGET_PATH', '../tests/Unit/');

require_once __DIR__ . '/../vendor/autoload.php';

$schema = json_decode(file_get_contents(__DIR__ . "/../resources/ethjs-schema.json"), true);

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


//  $constructor_content = makeConstructorContent($ordered_params);
//  $setters = makeSetFunctions($ordered_params);
//
//  $return_array = makeReturnArray($ordered_params);
//
//
//
//  $properties = makeProperties($ordered_params);


//  printMe ('Properties', $properties);
//  printMe ('Constructor', "__construct(" . $constructor . ")");
//  printMe ('ConstructorContent', $constructor_content);
//  printMe ('Set&lt;PROPERTY&gt;', $setters);
//  printMe ('Return Array', $return_array);

    $data = [
        "<?php\n",
        // TODO THIS DOSN'T WORK: Drupal Namespace not recognized.
        "namespace Ethereum;",
        "use Ethereum\EthTest;",
        "use Ethereum\Ethereum;\n",
        "/**",
        " * Test for $method_name.",
        " * @ingroup tests",
        " */",
        "class " . $class_name . "Test extends EthTest {\n",
        makeConstructor(),
        "",
        "  /**",
        "   * Testing. $method_name",
        "   * @ingroup tests",
        "   */",
        "  public function test" . $class_name . "Initial() {\n",
        makeTestUnparameterised(),
        "  }",
        "}",
    ];

    $filename = TARGET_PATH . '/' . $class_name . 'Test.generatedTest.php';
    file_put_contents($filename, implode("\n", $data));
    chmod($filename, 0664);

    echo "<hr />";


}

// echo "<h1>SCHEMA</h1>";
// var_dump($schema);


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


/**
 * Create constructor content.
 *
 */
function makeConstructor()
{
    $val[] = '  protected $controller;' . "\n";
    $val[] = '  public function __construct(){';
    $val[] = '    parent::__construct();';
    $val[] = '    $this->controller = new Ethereum();';
    $val[] = '  }';

    // Required params first.

    return implode("\n", $val);
}

/**
 * Create test for unparameterised call.
 *
 */
function makeTestUnparameterised()
{
    global $valid_arguments, $method_name, $return_type;
    if (count($valid_arguments) == 0) {
        $val[] = '    $x = $this->controller->client->' . $method_name . '();';
        $val[] = '    $this->assertEquals($x->getType($schema = TRUE), "' . $return_type . '");';

        return implode("\n", $val);
    } else {
        return "";
    }
}
