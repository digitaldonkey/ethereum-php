<?php

namespace Ethereum;

use Graze\GuzzleHttp\JsonRpc\Client as RpcClient;
use Ethereum\EthDataTypePrimitive;
use Ethereum\EthD;
use Ethereum\EthD20;
use Ethereum\EthD32;
use Ethereum\EthS;
use Ethereum\EthQ;
use Ethereum\EthB;
use Ethereum\EthBlockParam;
use Ethereum\EthData;

/**
 * Ethereum JsonRPC API for PHP.
 *
 * Implements Ethereum JsonRPC API for PHP
 *   https://github.com/ethereum/wiki/wiki/JSON-RPC.
 *
 * This part of the Drupal Ethereum Module:
 * https://groups.drupal.org/ethereum
 *
 * Ethereum class is based on ethjs-schema by Nick Dodson.
 *   https://github.com/digitaldonkey/ethjs-schema
 */
class Ethereum extends EthereumStatic {

  private $definition;
  private $methods;
  protected $id = 0;
  public $client;
  private $debug = FALSE;

  /**
   * Constructor.
   */
  public function __construct($url) {

    $this->client = RpcClient::factory($url, array(
      'debug' => FALSE,
    ));

    $schema_path = substr(__DIR__, 0, -strlen('src')) . 'ethjs-schema.json';
    $this->definition = json_decode(file_get_contents($schema_path), TRUE);;

    foreach ($this->definition['methods'] as $name => $params) {
      ${$name} = function () {

        $this->debug = TRUE;
        $request_params = array();

        // Get name of called function.
        $method = debug_backtrace()[2]['args'][0];
        $this->debug('Called function name', $method);

        // Get call and return parameters and types.
        $param_definition = $this->definition['methods'][$method];

        // Arguments send with function call.
        $valid_arguments = $param_definition[0];
        $argument_class_names = array();
        if (count($valid_arguments)) {
          $this->debug('Valid arguments', $valid_arguments);

          // Get argument definition Classes.
          foreach ($valid_arguments as $type) {
            $argument_class_names[] = EthDataTypePrimitive::typeMap($type);
          }
          $this->debug('Valid arguments class names', $argument_class_names);
        }

        // Arguments send with function call.
        $args = func_get_args();
        if (count($args) && isset($argument_class_names)) {
          $this->debug('Arguments', $args);

          // Validate arguments.
          foreach ($args as $i => $arg) {
            if ($argument_class_names[$i] !== $arg->getType()) {
              throw new \InvalidArgumentException("Argument $i is " . $arg->getType() . " but expected $argument_class_names[$i] in $method().");
            }
            else {
              // Add hex value.
              $request_params[] = $arg->hexVal();
            }
          }
        }


        // Validate required parameters.
        if (isset($param_definition[2])) {
          $required_params = array_slice($param_definition[0], 0, $param_definition[2]);
          $this->debug('Required Params', $required_params);
        }

        if (count($required_params)) {
          foreach ($required_params as $i => $param) {
            if (!isset($request_params[$i])) {
              throw new \InvalidArgumentException("Required argument $i $argument_class_names[$i] is missing in $method().");
            }
          }
        }

        // TODO Ensure default block param.
        // Default block parameter required for function call?
        // See: https://github.com/ethereum/wiki/wiki/JSON-RPC#the-default-block-parameter.
        $require_default_block = FALSE;
        if (isset($param_definition[3])) {
          $require_default_block = $param_definition[3];
          $this->debug('Require default block parameter', $require_default_block);
        }
        if ($require_default_block) {
          $arg_is_set = FALSE;
          foreach ($argument_class_names as $i => $class) {
            if ($class === 'EthBlockParam' && !isset($request_params[$i])) {
              $request_params[$i] = 'latest';
            }
          }
        }

        // Return type.
        $return_type = $param_definition[1];
        $this->debug('Return value type', $return_type);

        $return_type_class = EthDataTypePrimitive::typeMap($return_type);
        $this->debug('Return value Class name ', $return_type_class);

        // Call.
        $this->debug('Final request params', $request_params);
        $value = $this->ether_request($method, $request_params);

        // Create return value.
        $classname = "\Ethereum\\" . $return_type_class;

        return new $classname($value);
      };
      // Binding above function.
      $this->methods[$name] = \Closure::bind(${$name}, $this, get_class());
    }
  }

  /**
   * Method call wrapper.
   */
  public function __call($method, $args) {

    $X = FALSE;


    if(is_callable($this->methods[$method])) {

      $X = FALSE;

      return call_user_func_array($this->methods[$method], $args);
    }
    else {
      throw new \InvalidArgumentException('Unknown Method: ' . $method);
    }
  }

  /**
   * Request().
   */
  public function request($method, array $params = []) {
    $this->id++;
    return $this->client->send($this->client->request($this->id, $method, $params))->getRpcResult();
  }

  /**
   * Ethereum request.
   */
  private function ether_request($method, $params = array()) {

    try {
      return $this->request($method, $params);
    }
    catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * printMe().
   */
  private function debug($title, $content = NULL) {
    $X = FALSE;
    if ($this->debug) {
      echo '<p style="margin-left: 1em"><b>' . $title . "</b></p>";
      if ($content) {
        echo '<pre style="background: Azure; margin-left: 1em; padding: .25em .5em">';
        if (is_array($content)) {
          print_r($content);
        }
        else {
          echo ($content);
        }
        echo "</pre>";
      }
    }
  }

}
