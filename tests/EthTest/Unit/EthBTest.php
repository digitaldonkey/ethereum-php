<?php
namespace Ethereum;
use Ethereum\DataType\EthB;
use Ethereum\TestStatic;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup staticTests
 */
class EthereumStaticTestEthB extends TestStatic {

  /**
   * Init with ABI.
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__int_with_abi() {
    $x = new EthB(1, array('abi' => 'bool'));
    $this->assertSame($x->getSchemaType(), "B");
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

  /**
   * Int to bool.
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__int() {
    $x = new EthB(1);
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

  /**
   * Int null to bool..
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__int_null() {
    $x = new EthB(0);
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->val(), FALSE);
  }

  /**
   * Hex bool to true.
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__bool_true() {

    $x = new EthB(TRUE, array('abi' => 'bool'));

    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

  /**
   * Hex bool to false.
   * @ingroup PrimitiveDataType
   */
  public function testEthB__bool_false() {
    $x = new EthB(FALSE, array('abi' => 'bool'));
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->val(), FALSE);
  }

  /**
   * Hex false to false.
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__hex_false() {
    $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
    $this->assertSame($x->val(), FALSE);
  }

  /**
   * Hex true to true.
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__hex_TRUE() {
    $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000001', array('abi' => 'bool'));
    $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
    $this->assertSame($x->val(), TRUE);
  }

}
