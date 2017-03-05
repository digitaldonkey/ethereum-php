<?php

namespace Ethereum;
use Ethereum\EthereumStatic;

/**
 *
 */
class EthereumStaticTest extends \PHPUnit_Framework_TestCase {

  /**
   * This test is bases data by http://codebeautify.org/hex-string-converter.
   */
  public function testHexToStr() {

    $str = EthereumStatic::hexToStr('0x' . '48656c6c6f20576f726c64');
    $this->assertEquals($str, "Hello World");

    $str = EthereumStatic::hexToStr('0x' . '48656c6cdc20576f726c64');
    $this->assertEquals($str, "HellÜ World");

    $str = EthereumStatic::hexToStr('0x' . '2748656c6cd620576f726c6427');
    $this->assertEquals($str, "'HellÖ World'");

    $str = EthereumStatic::hexToStr('0x' . '2248656c6cd620576f726c6422');
    $this->assertEquals($str, '"HellÖ World"');

    $str = EthereumStatic::hexToStr('0x' . '2248656c6cf6204d7923603f3d29282f262524a722213e20576f726c6422');
    $this->assertEquals($str, '"Hellö My#`?=)(/&%$§"!> World"');

    $str = EthereumStatic::hexToStr('0x' . 'e4f6fc');
    $this->assertEquals($str, 'äöü');

    $str = EthereumStatic::hexToStr('0x' . 'c4d6dc');
    $this->assertEquals($str, 'ÄÖÜ');

    // Some basic visible UTF-8 Chars.
    $str = EthereumStatic::hexToStr('0x' . '2122232425262728292a2b2c2d2e2f303132333435363738393a3b3c3d3e3f404142434445464748494a4b4c4d4e4f505152535455565758595a5b5c5d5e5f606162636465666768696a6b6c6d6e6f707172737475767778797a7b7c7d7ea1a2a3a4a5a6a7a8a9aaabacadaeafb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebeced');
    $this->assertEquals($str, '!"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìí');

    // Seems not to work with a broader UTF-8 set.
    // $str = EthereumStatic::hexToStr('0x' . 'fffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffd2021222324252628292a2b2c2d2e2f303132333435363738393a3b3c3d3e3f404142434445464748494a4b4c4d4e4f505152535455565758595a5b5c5d5e5f606162636465666768696a6b6c6d6e6f707172737475767778797a7b7c7d7efffdfffdfffdfffdfffdfffd85fffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffda0a1a2a3a4a5a6a7a8a9aaabacadaeafb0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebecedeeeff0f1f2f3f4f5f6f7f8f9fafbfcfdfeff10010110210310410510610710810910a10b10c10d10e10f11011111211311411511611711811911a11b11c11d11e11f12012112212312412512612712812912a12b12c12d12e12f13013113213313413513613713813913a13b13c13d13e13f14014114214314414514614714814914a14b14c14d14e14f15015115215315415515615715815915a15b15c15d15e15f16016116216316416516616716816916a16b16c16d16e16f17017117217317417517617717817917a17b17c17d17e17f18018118218318418518618718818918a18b18c18d18e18f19019119219319419519619719819919a19b19c19d19e19f1a01a11a21a31a41a51a61a71a81a91aa1ab1ac1ad1ae1af1b01b11b21b31b41b51b61b71b81b91ba1bb1bc1bd1be1bf1c01c11c21c31c41c51c61c71c81c91ca1cb1cc1cd1ce1cf1d01d11d21d31d41d51d61d71d81d91da1db1dc1dd1de1df1e01e11e21e31e41e51e61e71e81e91ea1eb1ec1ed1ee1ef1f01f11f21f31f41f51f61f71f81f91fa1fb1fc1fd1fe1ff20020120220320420520620720820920a20b20c20d20e20f21021121221321421521621721821921a21b21c21d21e21f22022122222322422522622722822922a22b22c22d22e22f23023123223323423523623723823923a23b23c23d23e23f240241fffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffdfffd25025125225325425525625725825925a25b25c25d25e25f26026126226326426526626726826926a26b26c26d26e26f27027127227327427527627727827927a27b27c27d27e27f28028128228328428528628728828928a28b28c28d28e28f29029129229329429529629729829929a29b29c29d29e29f2a02a12a22a32a42a52a62a72a82a92aa2ab2ac2ad2ae2af2b02b12b22b32b42b52b62b72b82b92ba2bb2bc2bd2be2bf2c02c12c22c32c42c52c62c72c82c92ca2cb2cc2cd2ce2cf2d02d12d22d32d42d52d62d72d82d92da2db2dc2dd2de2df2e02e12e22e32e42e52e62e72e82e92ea2eb2ec2ed2ee2ef2f02f12f22f32f42f52f62f72f82f92fa2fb2fc2fd2fe2ff');
    // $this->assertEquals($str, '������������������ !"#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~�������������������������������� ¡¢£¤¥¦§¨©ª«¬­®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿĀāĂăĄąĆćĈĉĊċČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĸĹĺĻļĽľĿŀŁłŃńŅņŇňŉŊŋŌōŎŏŐőŒœŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƀƁƂƃƄƅƆƇƈƉƊƋƌƍƎƏƐƑƒƓƔƕƖƗƘƙƚƛƜƝƞƟƠơƢƣƤƥƦƧƨƩƪƫƬƭƮƯưƱƲƳƴƵƶƷƸƹƺƻƼƽƾƿǀǁǂǃǄǅǆǇǈǉǊǋǌǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǝǞǟǠǡǢǣǤǥǦǧǨǩǪǫǬǭǮǯǰǱǲǳǴǵǶǷǸǹǺǻǼǽǾǿȀȁȂȃȄȅȆȇȈȉȊȋȌȍȎȏȐȑȒȓȔȕȖȗȘșȚțȜȝȞȟȠȡȢȣȤȥȦȧȨȩȪȫȬȭȮȯȰȱȲȳȴȵȶȷȸȹȺȻȼȽȾȿɀɁ��������������ɐɑɒɓɔɕɖɗɘəɚɛɜɝɞɟɠɡɢɣɤɥɦɧɨɩɪɫɬɭɮɯɰɱɲɳɴɵɶɷɸɹɺɻɼɽɾɿʀʁʂʃʄʅʆʇʈʉʊʋʌʍʎʏʐʑʒʓʔʕʖʗʘʙʚʛʜʝʞʟʠʡʢʣʤʥʦʧʨʩʪʫʬʭʮʯʰʱʲʳʴʵʶʷʸʹʺʻʼʽʾʿˀˁ˂˃˄˅ˆˇˈˉˊˋˌˍˎˏːˑ˒˓˔˕˖˗˘˙˚˛˜˝˞˟ˠˡˢˣˤ˥˦˧˨˩˪˫ˬ˭ˮ˯˰˱˲˳˴˵˶˷˸˹˺˻˼˽˾˿';

  }

}
