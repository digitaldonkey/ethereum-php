<?php


namespace Ethereum;

use Ethereum\DataType\EthD;
use Ethereum\DataType\EthDataType;
use Ethereum\RLP\Rlp;

class Abi extends EthereumStatic
{

    /**
     * @var $abi
     */
    private $abi;


    /**
     * Abi constructor.
     * @param array $abi
     */
    public function __construct(array $abi)
    {
        $this->abi = $abi;
    }


    /**
     * @param $methodName
     * @param $values array
     *
     * @return EthD
     * @throws \InvalidArgumentException
     */
    public function encodeFunction(string $methodName, array $values)
    {

        $m = $this->getParamDefinition($methodName);

        if (count($m->inputs) !== count($values)) {
            throw new \InvalidArgumentException('Expected ' . count($m->inputs) . ' params but got ' . count($values));
        }

        // [METHOD 4bytes] + [PARAMS]
        $params = $this->getSignature($m);
        foreach ($values as $i => $val) {
            $expectedType = $m->inputs[$i]->type;
            $validAbiType = self::convertByAbi($expectedType, $val);
            $params .= EthereumStatic::removeHexPrefix($validAbiType->encodedHexVal());
        }
        return new EthD($params);
    }

    /**
     * Decode return values of Abi $method.
     *
     * Iterate trough expected return values
     *
     * Decide fixed / dynamic and decode acordingly.
     *
     * @param $method
     * @param $rawReturn
     *
     * @return array
     *
     * @throws \Ethereum\Exception
     */
    public function decode(string $method, EthD $rawReturn)
    {
        $return = [];
        $m = $this->getParamDefinition($method);

        $pos = 0;
        $msgData = self::removeHexPrefix($rawReturn->hexVal());

        foreach ($m->outputs as $p => $param) {

            $class = EthD::getClassByAbi($param->type);

            $lengthType = $class::getdataLengthType($param->type);

            if ($lengthType === 'static') {
                // Fixed lenth type.
                $thisValue = substr($msgData, $pos, 64);
                $return[$p] = new $class(self::ensureHexPrefix($thisValue), ['abi' => $param->type]);
            }
            elseif ($lengthType === 'dynamic') {
                // Dynamic length type.
                $offsetInChars = 2 * Rlp::getByteValueAtOffsetPos($msgData, $pos);
                $rlpDecoded = Rlp::decode(substr($msgData, $offsetInChars));

                if (count($rlpDecoded) === 1) {
                    $return[$p] = new $class(self::ensureHexPrefix($rlpDecoded[0]->get()), ['abi' => $param->type]);
                }
                else {
                    foreach ($rlpDecoded as $rlpItem) {
                        $return[$p][] = new $class(self::ensureHexPrefix($rlpItem->get()), ['abi' => $param->type]);
                    }
                }
            }
            else {
                throw new \Exception('Lengtht type must be "dynamic" or "static".');
            }
            $pos += 64;
        }

        // Only return array if we expect multiple params.
        if (count($m->outputs) === 1) {
            $return = $return[0];
        }
        return $return;
    }


    /**
     * Filter Abi for a given Method and return the definiton.
     *
     * @param $methodName
     * @return array
     * @throws Exception
     *  If method does not exist.
     */
    public function getParamDefinition($methodName)
    {
        foreach ($this->abi as $item) {
            if (isset($item->name)
              && isset($item->type)
              && $item->type === 'function'
              && $item->name === $methodName
            ) {
                return $item;
            }
        }
        throw new \Exception('Called undefined contract method: ' . $methodName . '.');
    }


    /**
     * @param $m
     *    Method as returned from self::getParamDefinition()
     * @return string
     *    Function signature. E.g: multiply(uint256).
     */
    private static function getSignature(object $m)
    {
        $sign = $m->name . '(';
        foreach ($m->inputs as $i => $item) {
            $sign .= $item->type;
            if ($i < count($m->inputs) - 1) {
                $sign .= ',';
            }
        }
        $sign .= ')';
        return self::getMethodSignature($sign);
    }

    /**
     * Convert EthD value into ABI expected value.
     *
     * @todo Not fully implemented. Requires full test coverage.
     *
     * This function maps the Ethereum data type ABI to the Ethereum\DataType\<Class>
     *
     * https://solidity.readthedocs.io/en/develop/abi-spec.html#types
     *
     * Other implementations:
     * https://github.com/ethereumjs/ethereumjs-abi/blob/71f123b676f2b2d81bc20f343670d90045a3d3d8/lib/index.js#L427-L485
     * https://github.com/Nethereum/Nethereum/blob/9eb30b298a28634d41034c1cc4b1c0354a37c175/src/Nethereum.ABI/ABIType.cs#L34-L58
     *
     * Test examples:
     * https://github.com/ethereumjs/ethereumjs-abi/blob/master/test/index.js
     * https://github.com/ethereum/web3.js/blob/master/test/coder.encodeParam.js
     * https://github.com/ethereum/web3.js/blob/master/test/coder.decodeParam.js
     *
     * @param string $abiType
     *   Expected Abi type.
     *
     * @throws Exception
     *    If conversation is not implemented for ABI type.
     *
     * @return object
     *   Return object of the expected data type and the value.
     */
    public static function convertByAbi(string $abiType, EthD $value)
    {

        // T[k] for any dynamic T and any k > 0
        // <type>[]: a variable-length array of elements of the given type.
        if (strpos($abiType, '[')) {
            // @todo
        }

        // (T1,...,Tk) if any Ti is dynamic for 1 <= i <= k
        // (T1,T2,...,Tn): tuple consisting of the types T1, …, Tn, n >= 0
        if (strpos($abiType, '(')) {
            // @todo
        }

        $class = EthDataType::getClassByAbi($abiType);
        if ($class) {
            return new $class($value->hexVal(), ['abi' => $abiType]);
        }

        throw new Exception('Can not convert to unknown type ' . $abiType . '. Might be not implemented yet.');
    }

}
