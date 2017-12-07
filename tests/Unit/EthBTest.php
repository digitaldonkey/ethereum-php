<?php
namespace Ethereum;
use Ethereum\EthB;
use Ethereum\EthTest;

/**
 * EthereumStaticTestEthB
 *
 * @ingroup tests
 */
class EthereumStaticTestEthB extends EthTest {

  /**
   * Init with ABI.
   *
   * @ingroup PrimitiveDataType
   */
  public function testEthB__int_with_abi() {
    $x = new EthB(1, array('abi' => 'bool'));
    $this->assertSame($x->getType($schema = FALSE), "EthB");
    $this->assertSame($x->getType($schema = TRUE), "B");
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


//class EthBTest extends TestCase
//{
//    /**
//     * Testing quantities.
//     * @throw Exception
//     */
//    public function testEthB__int_with_abi()
//    {
//        $x = new EthB(1, ['abi' => 'bool']);
//        $this->assertSame($x->getType($schema = false), "EthB");
//        $this->assertSame($x->getType($schema = true), "B");
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
//        $this->assertSame($x->val(), true);
//    }
//>>>>>>> c05a182b196a13cc25590d1806213795f0be32ee:test/EthBTest.php
//
//    /**
//     * @throw Exception
//     */
//    public function testEthB__int()
//    {
//        $x = new EthB(1);
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
//        $this->assertSame($x->val(), true);
//    }
//
//    /**
//     * @throw Exception
//     */
//    public function testEthB__int_null()
//    {
//        $x = new EthB(0);
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
//        $this->assertSame($x->val(), false);
//    }
//
//
//    /**
//     * @throw Exception
//     */
//    public function testEthB__bool_true()
//    {
//
//        $x = new EthB(true, ['abi' => 'bool']);
//
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
//        $this->assertSame($x->val(), true);
//    }
//
//    /**
//     * @throw Exception
//     */
//    public function testEthB__bool_false()
//    {
//        $x = new EthB(false, ['abi' => 'bool']);
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
//        $this->assertSame($x->val(), false);
//    }
//
//    /**
//     * @throw Exception
//     */
//    public function testEthB__hex_false()
//    {
//        $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000000');
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
//        $this->assertSame($x->val(), false);
//    }
//
//    /**
//     * @throw Exception
//     */
//    public function testEthB__hex_TRUE()
//    {
//        $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000001', ['abi' => 'bool']);
//        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
//        $this->assertSame($x->val(), true);
//    }
//}
