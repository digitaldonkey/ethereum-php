<?php
namespace Ethereum;
use Ethereum\EthTest;
use Ethereum\EthDataType;

/**
 * EthereumStaticTest
 *
 * @ingroup staticTests
 */
class EthDataTypeTest extends EthTest
{

    private $allTypes;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->allTypes = EthDataType::getAllTypeClasses();
    }

    /**
     * @covers EthDataType::getTypeClass
     */
    public function testGetTypeClass() {
        foreach ($this->allTypes as $type) {
            $this->assertEquals(EthDataType::getTypeClass(array($type), true), 'array');
            $this->assertEquals(EthDataType::getTypeClass(array($type), false), $type);
            $this->assertEquals(EthDataType::getTypeClass($type, true), $type);
            $this->assertEquals(EthDataType::getTypeClass($type, false), $type);
        }
    }

}
