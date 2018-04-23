<?php
use Ethereum\Ethereum;
use Ethereum\DataType\EthD32;
use Ethereum\SmartContract;

/**
 * @var bool IS_PUBLIC Deny public access to this generator.
 */
define('IS_PUBLIC', TRUE);

require_once __DIR__ . '/examples.inc.php';
?>

<h3>Example: Register Drupal</h3>
<p>
    <a href="https://github.com/digitaldonkey/register_drupal_ethereum">Smart contract</a>
    is <a href="https://kovan.etherscan.io/address/0xdacb85f3a6f12ca7893f887f875064880ce14d7d">deployed at</a>
    Kovan network.</b>
</p>
<p>
    It is a simple registry, where user <em>submit</em> a Hash provided by the CMS to a registry.
    Imagine the registry a a simple array.
</p>
<p>
    The <b>validateUserByHash(hash)</b> function returns the submitting user address.
</p>

<?php

// Contract Address on kovan network.
$addressAtKovan = '0xdacb85f3a6f12ca7893f887f875064880ce14d7d';

// Hash which has been submitted at this contract by the user "0xaec98826319ef42aab9530a23306d5a9b113e23d".
$exampleHash = "0x6139633364613535613365333161396433353334353934376261323439353232";

// ABI of the Contract
//
// See also:
// Contract on Github: https://github.com/digitaldonkey/register_drupal_ethereum
// Deployed contract https://kovan.etherscan.io/address/0xdacb85f3a6f12ca7893f887f875064880ce14d7d
//
// The ABI of a contract can be gathered using solc (pure javascript compiler),
//   on Remix http://remix.ethereum.org or  with tools like Truffle truffleframework.com
$abi = json_decode('[
    {
      "inputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "constructor"
    },
    {
      "constant": true,
      "inputs": [
        {
          "name": "drupalUserHash",
          "type": "bytes32"
        }
      ],
      "name": "validateUserByHash",
      "outputs": [
        {
          "name": "result",
          "type": "address"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "anonymous": false,
      "inputs": [
        {
          "indexed": true,
          "name": "from",
          "type": "address"
        },
        {
          "indexed": true,
          "name": "hash",
          "type": "bytes32"
        },
        {
          "indexed": false,
          "name": "error",
          "type": "int256"
        }
      ],
      "name": "AccountCreatedEvent",
      "type": "event"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "from",
          "type": "address"
        },
        {
          "name": "hash",
          "type": "bytes32"
        },
        {
          "name": "error",
          "type": "int256"
        }
      ],
      "name": "accountCreated",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "drupalUserHash",
          "type": "bytes32"
        }
      ],
      "name": "newUser",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "contractExists",
      "outputs": [
        {
          "name": "result",
          "type": "bool"
        }
      ],
      "payable": false,
      "stateMutability": "pure",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "registrationDisabled",
          "type": "bool"
        }
      ],
      "name": "adminSetRegistrationDisabled",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "accountAdmin",
          "type": "address"
        }
      ],
      "name": "adminSetAccountAdministrator",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [],
      "name": "adminRetrieveDonations",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [],
      "name": "adminDeleteRegistry",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    }
  ]');

try {
    // Ethereum instance connected to Kovan network.
    $eth = new Ethereum('https://kovan.infura.io/drupal');
    $hash = new EthD32($exampleHash);

    // Instanciate Contract.
    $register_drupal = new SmartContract($abi, $addressAtKovan, $eth);

    // Call a function.
    // Note Return type is D20 which is a the same as "address".
    $test = $register_drupal->validateUserByHash($hash);

    // Show results.
    echo "<p style='color: forestgreen;'>The Address submitted this hash is:<br />";
    echo $test->hexVal()."</p>";

    }
catch (\Exception $exception) {
    echo "<p style='color: red;'>We have a problem:<br />";
    echo $exception->getMessage() . "</p>";
    echo "<pre>" . $exception->getTraceAsString() . "</pre>";
}
