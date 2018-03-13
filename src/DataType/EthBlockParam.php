<?php

namespace Ethereum\DataType;
use Math_BigInteger;

/**
 * Default block parameter.
 *
 * @see: https://github.com/ethereum/wiki/wiki/JSON-RPC#the-default-block-parameter.
 */
class EthBlockParam extends EthQ
{
    const TAGS = [
        "latest",
        "earliest",
        "pending",
    ];

    /**
     * Constructor.
     *
     * @param string|int $val
     *   Hexadecimal or number value.
     * @param array      $params
     *   Array with optional parameters. Add Abi type $params['abi'] = 'unint8'.
     * @throw InvalidArgumentException
     */
    public function __construct($val = 'latest', array $params = [])
    {
        parent::__construct($val, $params);
    }

    /**
     * Implement validation.
     *
     * @param string|int $val
     *   Integer block number.
     * @param array      $params
     *   Only $param['abi'] is relevant.
     *
     * @throw InvalidArgumentException Value is not a valid block param
     *
     * @return string.
     */
    public function validate($val, array $params)
    {
        $return = null;
        if ($this->isTag($val)) {
            $return = $val;
        } else {
            $return = parent::validate($val, $params);
        }

        if (is_null($return)) {
            throw new \InvalidArgumentException('No valid block param: ' . $val);
        }

        return $return;
    }

    /**
     * Return un-prefixed bin value.
     *
     * @return int|string|Math_BigInteger
     *   Return a PHP integer.
     *   If $val > PHP_INT_MAX we return a string containing the integer.
     */
    public function val()
    {
        if ($this->isTag()) {
            return $this->value;
        } else {
            return $this->value->toString();
        }
    }

    /**
     * Check if value is a block-tag.
     *
     * @param $val
     *   Value to check. Assuming $this->value if not given.
     * @return bool
     *   True if given value or $this->value is a tag.
     */
    protected function isTag($val = false)
    {
        if (!$val) {
            $val = $this->value;
        }

        return (!is_int($val) && in_array($val, self::TAGS));
    }

    /**
     * Return hex encoded block number or tag.
     *
     * @return int|string|Math_BigInteger
     *   Return a PHP integer.
     *   If $val > PHP_INT_MAX we return a string containing the integer.
     */
    public function hexVal()
    {
        if ($this->isTag()) {
            return $this->value;
        } else {
            $val = intval($this->value->toString());
            $val = ($val === 0) ? $val : $this->value->toHex(false);

            // Unpaded positive Hex value.
            return $this->ensureHexPrefix($val);
        }
    }

    /**
     * Call EthD20 validation to validate Address.
     * @throw InvalidArgumentException
     */
    protected function validateAddress($val, array $params)
    {
        return parent::validate($val, $params);
    }
}
