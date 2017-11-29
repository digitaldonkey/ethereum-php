<?php

namespace Ethereum;

/**
 * Implement data type SHHFilter.
 */
class SHHFilter extends EthDataType
{
    protected $topics;
    protected $to;

    /**
     * Constructor.
     * @param array     $topics
     * @param EthD|null $to
     */
    public function __construct(array $topics, EthD $to = null)
    {
        $this->topics = $topics;
        $this->to = $to;
    }

    public function setTopics(EthD $value)
    {
        if (is_object($value) && is_a($value, 'EthD')) {
            $this->topics = $value;
        } else {
            $this->topics = new EthD($value);
        }
    }

    public function setTo(EthD $value)
    {
        if (is_object($value) && is_a($value, 'EthD')) {
            $this->to = $value;
        } else {
            $this->to = new EthD($value);
        }
    }

    public function getType()
    {
        return 'SHHFilter';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $return = [];
        (!is_null($this->topics)) ? $return['topics'] = EthereumStatic::valueArray($this->topics, 'D') : [];
        (!is_null($this->to)) ? $return['to'] = $this->to->hexVal() : null;

        return $return;
    }

    /**
     * Returns a name => type array.
     */
    public static function getTypeArray()
    {
        return [
            'topics' => 'EthD',
            'to'     => 'EthD',
        ];
    }
}