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

        $debug = TRUE;

        // Get name of called function.
        $method = debug_backtrace()[2]['args'][0];
        echo $debug ? "<b>Called function name</b> <br />" . $method . "<br />" : '';

        // Get call and return parameters and types.
        $param_definition = $this->definition['methods'][$method];

        // Arguments send with function call.
        $args = func_get_args();
        if (count($args)) {
          echo $debug ? "<br /><b>Arguments</b>" : '';
          echo $debug ? '<pre style="background: Azure">' . print_r($args, TRUE) . "</pre></small>" : '';
        }

        // Return values and types.
        echo $debug ? "<br /><b>Return value</b>" : '';
        echo $debug ? '<pre style="background: Azure">' . print_r($param_definition[1], TRUE) . "</pre></small>" : '';

        echo $debug ? "<br /><b>Return value Class name</b>" : '';
        echo $debug ? '<pre style="background: Azure">' . print_r(EthDataTypePrimitive::typeMap($param_definition[1]), TRUE) . "</pre></small>" : '';


        // Required parameter names.
        if (isset($param_definition[2])) {
          echo $debug ? "<br /><b>Required Params: </b>" : '';
          $required = array_slice($param_definition[0], 0, $param_definition[2]);
          echo $debug ? '<pre style="background: Azure">' . print_r($required, TRUE) . "</pre></small>" : '';
        }

        // True if default block parameter required for function call.
        // See: https://github.com/ethereum/wiki/wiki/JSON-RPC#the-default-block-parameter.
        if (isset($param_definition[3])) {
          echo $debug ? "<br /><b>Require block parameter: </b>" : '';
          echo $debug ? '<pre style="background: Azure">TRUE</pre></small>' : '';
        }

        // TODO Validate Call params.

        // Call.
        $value = $this->ether_request($method, $params = array());

        // Create return value.
        $classname = "\Ethereum\\" . EthDataTypePrimitive::typeMap($param_definition[1]);

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
}
