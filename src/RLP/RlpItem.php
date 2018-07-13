<?php

namespace Ethereum\RLP;


class RlpItem extends Rlp
{

    // Data String.
    protected $rlpData;

    // StrLength of tha actual Data.
    protected $dataStrLength;

    // Padded strLength of arg incl prefix.
    protected $paddedStrLength;

    public function __construct($data)
    {
        $dataLength = self::getStringLengthAt($data, 0);
        $this->dataStrLength = $dataLength;
        $this->paddedStrLength = 64 + self::paddedLength($dataLength);
        $this->rlpData = substr($data, 64, $this->dataStrLength);
    }

    public function getCharLength()
    {
        return $this->paddedStrLength;
    }

    public function get()
    {
        return $this->rlpData;
    }

}
