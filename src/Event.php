<?php
/**
 * Created by PhpStorm.
 * User: tho
 * Date: 18.07.18
 * Time: 17:05
 */

namespace Ethereum;
use Ethereum\DataType\FilterChange;
use Ethereum\DataType\Receipt;
use Ethereum\DataType\Transaction;

class Event extends EthereumStatic
{

    protected $name;
    protected $anonymous;
    protected $inputs;
    protected $abi;

    public function __construct($abiItem)
    {
        $this->abi = $abiItem;
        $this->inputs = $abiItem->inputs;
        $this->name = $abiItem->name;
        $this->anonymous = $abiItem->anonymous;
    }

    /**
     * @param \Ethereum\DataType\FilterChange $filterChange
     * @return array
     * @throws \Exception
     */
    public function decode(FilterChange $filterChange) {
        $values = []; // Intermediate return value store
        $abiDecode = []; // Params we require to decode un-indexed data part.
        $return = []; // Final ordered return values.

        // Removing topic[0]. Topic[1-n] are indexed values.
        $indexedValues = array_slice($filterChange->topics, 1);

        foreach ($this->inputs as $i => $param) {
            if ($param->indexed) {
                $values[$param->name] = $indexedValues[$i]->convertByAbi($param->type);
            }
            else {
                $abiDecode[] = $param;
            }
        }

        // Decode the Data part
        if (count($abiDecode)) {
            $decoded = Abi::decode($abiDecode, self::removeHexPrefix($filterChange->data->hexVal()));
            foreach ($abiDecode as $i => $param) {
                $values[$param->name] = $decoded[$i];
            }
        }

        // Restore array order (array_values($return) should return the right param order).
        foreach ($this->inputs as $i => $param) {
            $return[$param->name] = $values[$param->name];
        }
        return $return;
    }


    /**
     * @return string
     */
    public function getSignature() {
        $sign = $this->name . '(';
        foreach ($this->inputs as $i => $item) {
            $sign .= $item->type;
            if ($i < count($this->inputs) - 1) {
                $sign .= ',';
            }
        }
        $sign .= ')';
        return $sign;
    }

    /**
     * @return string
     */
    public function getTopic() {
        return $this->sha3($this->getSignature());
    }

    /**
     * @return string
     */
    public function getHandler () {
        return 'on' . ucfirst($this->name);
    }

    /**
     * @return object
     */
    public function getAbi() {
        return $this->abi;
    }

    public function getName() {
      return $this->name;
    }
}
