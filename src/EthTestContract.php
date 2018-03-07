<?php
namespace Ethereum;

use Ethereum\EthTest;
/**
 * @defgroup tests Tests
 *
 * %Ethereum JsonRPC client tests.
 */

/**
 * Abstract base class for Tests
 *
 * @ingroup tests
 */
abstract class EthTestContract extends EthTest {

    /**
     * Ensure we have the constants
     *  SERVER_URL and NETWORK_ID available.
     * Default is the Ganache default config.
     *
     * You may define this vars in your shell before running tests.
     *  NETWORK_ID='1'
     *  SERVER_URL='http://localhost:8545'
     *  export NETWORK_ID
     *  export SERVER_URL
     *
     * NETWORK_ID is used to get the Contract Address from Truffle deployed contracts.
     * See build/contracts *.json
     *
     * "networks": {
     *  NETWORK_ID: {
     *  "events": {},
     *  "links": {},
     *  "address": "0x345ca3e014aaf5dca488057592ee47305d9b3e10"
     *  },
     *
     * @throws \Exception
     *    If  NETWORK_ID or SERVER_URL are not defined env vars in phpunit.xml.
     */
    public static function setUpBeforeClass() {

        $networkId = getenv("NETWORK_ID");
        $serverUrl = getenv("SERVER_URL");

        if ($networkId && $serverUrl) {
            if (!defined('SERVER_URL')) {
                define('SERVER_URL', $serverUrl);
            }
            if (!defined('NETWORK_ID')) {
                define('NETWORK_ID', $networkId);
            }
        }
        else
        {
            throw new \Exception(
                'NETWORK_ID and SERVER_URL should env vars be defined phpunit.xml to provide defaults.'
            );
        }
    }
}
