<?php

/**
 * Actually this is not working. Just leave it for reference.
*/
header("HTTP/1.1 401 Unauthorized");
exit;

define('TAGETPATH', './test');

require_once './includes.inc.php';

use Ethereum\EthDataTypePrimitive;

foreach ($schema['methods'] as $method_name => $params) {

  echo "<h3>" .  $method_name ."</h3>";

  $class_name = makeClassName($method_name);
  printMe('Class name base', $class_name);

  $valid_arguments = $params[0];
  $argument_class_names = array();
  if (count($valid_arguments)) {

    printMe('Valid arguments', $valid_arguments);

    // Get argument definition Classes.
    foreach ($valid_arguments as $type) {
      $primitiveType = EthDataTypePrimitive::typeMap($type);
      if ($primitiveType) {
        $argument_class_names[] = $primitiveType;
      }
      else {
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



  $data = array (
    "<?php\n",
    // TODO THIS DOSN'T WORK: Drupal Namespace not recognized.
    "use Drupal\\ethereum\\Controller\\EthereumController;\n",
    "/**",
    " * Test for $method_name.",
    " */",
    "class " . $class_name . "Test extends \\PHPUnit_Framework_TestCase {\n",
    makeConstructor(),
    "",
    "  /**",
    "   * Testing.",
    "   */",
    "  public function test" . $class_name . "Initial() {\n",
    makeTestUnparameterised(),
    "  }",
    "}",
  );

  file_put_contents ( TAGETPATH . '/' . $class_name . 'Test.generated.php',  implode("\n",$data));

  echo "<hr />";


}

// echo "<h1>SCHEMA</h1>";
// var_dump($schema);



/**
 * Make Class name.
 *
 * @param string $input -
 *   Method name
 *
 * @return string
 *   Derived Class name.
 */
function makeClassName($input) {
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
function makeConstructor() {
  $val[] = '  protected $controller;' . "\n";
  $val[] = '  public function __construct(){';
  $val[] = '    $this->controller = new EthereumController();';
  $val[] = '  }';
  // Required params first.

  return implode("\n",$val);
}

/**
 * Create test for unparameterised call.
 *
 */
function makeTestUnparameterised() {
  global $valid_arguments, $method_name, $return_type;
  if (count($valid_arguments) == 0) {
    $val[] = '    $x = $this->controller->client->' . $method_name . '();';
    $val[] = '    $this->assertEquals($x->getType($schema = TRUE), "' . $return_type . '");';
    return implode("\n",$val);
  }
  else {
    return "";
  }
}
