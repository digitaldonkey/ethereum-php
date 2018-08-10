<?php
namespace Ethereum;
use Ethereum\TestStatic;
use Ethereum\DataType\EthD32;

/**
 * EthereumStaticTest
 *
 * @ingroup staticTests
 */
class EthereumStaticTest extends TestStatic
{
    public function testValueArray() {

        // Testing simply data type.
        $values = [
            '0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd',
            '0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbac0'
        ];

        $this->assertEquals(
            Ethereum::valueArray($values, 'EthD32'),
            array(
                new EthD32('0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbacd'),
                new EthD32('0xf79e7980a566fec5caf9cf368abb227e537999998541bad324f61cf2906fbac0'),
            )
        );

    }
}
