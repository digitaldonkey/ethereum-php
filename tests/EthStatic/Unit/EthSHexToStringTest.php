<?php
namespace Ethereum;
use Ethereum\DataType\EthS;
use Ethereum\TestStatic;

/**
 * EthQTest
 *
 * @ingroup staticTests
 */
class EthSHexToStringTest extends TestStatic
{

    public function convertDataProvider()
    {
        return [
            // [UTF8, HEX]0x48656c6c6f20576f726c64
            ['Hello World', '48656c6c6f20576f726c64'],
            ['HellÜ World', '48656c6cc39c20576f726c64'],
            ["'HellÖ World'", '2748656c6cc39620576f726c6427'],
            ['"HellÖ World"', '2248656c6cc39620576f726c6422'],
            ['"Hellö My#`?=)(/&%$§"!> World"', '2248656c6cc3b6204d7923603f3d29282f262524c2a722213e20576f726c6422'],
            ['äöü', 'c3a4c3b6c3bc'],
            ['ÄÖÜ', 'c384c396c39c'],
            ['/', '2f'],
            ['\\', '5c'],
            [
                '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìí',
                '2122232425262728292a2b2c2d2e2f303132333435363738393a3b3c3d3e3f404142434445464748494a4b4c4d4e4f505152535455565758595a5b5d5e5f606162636465666768696a6b6c6d6e6f707172737475767778797a7b7c7d7ec2a1c2a2c2a3c2a4c2a5c2a6c2a7c2a8c2a9c2aac2abc2acc2adc2aec2afc2b0c2b1c2b2c2b3c2b4c2b5c2b6c2b7c2b8c2b9c2bac2bbc2bcc2bdc2bec2bfc380c381c382c383c384c385c386c387c388c389c38ac38bc38cc38dc38ec38fc390c391c392c393c394c395c396c397c398c399c39ac39bc39cc39dc39ec39fc3a0c3a1c3a2c3a3c3a4c3a5c3a6c3a7c3a8c3a9c3aac3abc3acc3ad'
            ]
        ];
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testHextoString($utf8, $hex)
    {
        $this->assertEquals($utf8, EthS::hexToStr($hex));
    }

    /**
     * @dataProvider convertDataProvider
     */
    public function testStringToHex($utf8, $hex)
    {
        $this->assertEquals($hex, EthS::strToHex($utf8));
    }
}
