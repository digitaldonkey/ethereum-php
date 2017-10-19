<?php


use Ethereum\EthQ;
use Ethereum\EthB;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class EthereumStaticTestEthB extends TestCase {

    /**
     * Testing quantities.
     * @throws Exception
     */
  public function testEthB__int_with_abi() {
    $x = new EthB(1, array('abi' => 'bool'));
    $this->assertSame($x->getType($schema = FALSE), "EthB");
    $this->assertSame($x->getType($schema = TRUE), "B");
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

    /**
     * @throws Exception
     */
    public function testEthB__int() {
    $x = new EthB(1);
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

    /**
     * @throws Exception
     */
    public function testEthB__int_null() {
    $x = new EthB(0);
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->val(), FALSE);
  }


    /**
     * @throws Exception
     */
    public function testEthB__bool_true() {

    $x = new EthB(TRUE, array('abi' => 'bool'));

    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

    /**
     * @throws Exception
     */
    public function testEthB__bool_false() {
    $x = new EthB(FALSE, array('abi' => 'bool'));
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->val(), FALSE);
  }

    /**
     * @throws Exception
     */
    public function testEthB__hex_false() {
    $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->val(), FALSE);
  }

    /**
     * @throws Exception
     */
    public function testEthB__hex_TRUE() {
    $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000001', array('abi'=> 'bool'));
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

}
