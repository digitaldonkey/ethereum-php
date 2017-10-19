<?php


use Ethereum\EthB;
use PHPUnit\Framework\TestCase;

class EthBTest extends TestCase
{
    /**
     * Testing quantities.
     * @throws Exception
     */
    public function testEthB__int_with_abi()
    {
        $x = new EthB(1, ['abi' => 'bool']);
        $this->assertSame($x->getType($schema = false), "EthB");
        $this->assertSame($x->getType($schema = true), "B");
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
        $this->assertSame($x->val(), true);
    }

    /**
     * @throws Exception
     */
    public function testEthB__int()
    {
        $x = new EthB(1);
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
        $this->assertSame($x->val(), true);
    }

    /**
     * @throws Exception
     */
    public function testEthB__int_null()
    {
        $x = new EthB(0);
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
        $this->assertSame($x->val(), false);
    }


    /**
     * @throws Exception
     */
    public function testEthB__bool_true()
    {

        $x = new EthB(true, ['abi' => 'bool']);

        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
        $this->assertSame($x->val(), true);
    }

    /**
     * @throws Exception
     */
    public function testEthB__bool_false()
    {
        $x = new EthB(false, ['abi' => 'bool']);
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
        $this->assertSame($x->val(), false);
    }

    /**
     * @throws Exception
     */
    public function testEthB__hex_false()
    {
        $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000000');
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000000');
        $this->assertSame($x->val(), false);
    }

    /**
     * @throws Exception
     */
    public function testEthB__hex_TRUE()
    {
        $x = new EthB('0x0000000000000000000000000000000000000000000000000000000000000001', ['abi' => 'bool']);
        $this->assertSame($x->hexVal(), '0x0000000000000000000000000000000000000000000000000000000000000001');
        $this->assertSame($x->val(), true);
    }
}
