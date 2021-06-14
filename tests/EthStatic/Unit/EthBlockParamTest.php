<?php
namespace Ethereum;

use Ethereum\DataType\EthBlockParam;
use Ethereum\TestStatic;

/**
 * EthBlockParamTest
 *
 * @ingroup staticTests
 */
class EthBlockParamTest extends TestStatic
{
    /**
     * Testing quantities.
     * @throw Exception
     */
    public function testEthBlockParam__address()
    {

        $x = new EthBlockParam('0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');
        $this->assertSame($x->val(), '363523949029425027178585641663023053417725031737');
        $this->assertSame($x->hexVal(), '0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');


        $x = new EthBlockParam('0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');
        $this->assertSame($x->val(), '363523949029425027178585641663023053417725031737');
        $this->assertSame($x->hexVal(), '0x3facfa472e86e3edaeaa837f6ba038ac01f7f539');
        $this->assertSame($x->getSchemaType(), "Q|T");
    }

    public function testEthBlockParam__tagLatest()
    {

        $x = new EthBlockParam('latest');
        $this->assertSame($x->val(), 'latest');
        $this->assertSame($x->hexVal(), 'latest');
    }

    public function testEthBlockParam__tagPending()
    {

        $x = new EthBlockParam('pending');
        $this->assertSame($x->val(), 'pending');
        $this->assertSame($x->hexVal(), 'pending');
    }

    public function testEthBlockParam__tagErliest()
    {

        $x = new EthBlockParam('earliest');
        $this->assertSame($x->val(), 'earliest');
        $this->assertSame($x->hexVal(), 'earliest');
    }
}
