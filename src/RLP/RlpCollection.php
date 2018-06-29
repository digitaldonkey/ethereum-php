<?php

namespace Ethereum\RLP;
use Ethereum\RLP\RlpItem;


class RlpCollection extends Rlp {

    protected $rlpItems = [];

    public function toArray() {
      $return = [];
      foreach($this->rlpItems as $item) {
        $return[] = $item->get();
      }
      return $return;
    }

    public function get() {
      return $this->rlpItems;
    }

    public function add(RlpItem $item) {
      $this->rlpItems[] = $item;
    }
}
