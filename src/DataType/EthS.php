<?php

namespace Ethereum\DataType;

/**
 * String data.
 *
 * @ingroup dataTypesPrimitive
 */
class EthS extends EthD
{
    /**
     * Implement validation.
     * @throw Exception
     */
    public function validate($val, array $params)
    {
        $return = null;

        // We are actually validating not much, just make sure it is a string.
        // @todo Me might require to fail on non-UTF8 chars.
        if ($this->hasHexPrefix($val)) {
            // Hex encoded string.
            $return = $this->hexToStr($val);
        } elseif (is_string($val)) {
            $return = $val;
        } elseif (is_string(strval($val))) {
            // Allow also Numbers as strings (e.g "1" or "-1").
            $return = $val;
        }
        if (is_string((string) $return)) {
            return $return;
        } else {
            throw new \InvalidArgumentException('Can not decode Hex string: ' . $val);
        }
    }

    /**
     * Get hexadecimal string representation.
     */
    public function hexVal()
    {
        return $this->strToHex($this->value);
    }

    /**
     * Get string.
     */
    public function val()
    {
        return $this->value;
    }
}
