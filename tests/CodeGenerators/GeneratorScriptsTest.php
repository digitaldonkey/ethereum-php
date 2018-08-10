<?php
namespace Ethereum;

/**
 * GeneratorScriptsTest
 *
 * @ingroup staticTests
 */
class GeneratorScriptsTest extends TestStatic {

    /*
     * Testing code generators
     *
     * Using --no-file-generation flag, run generation code,
     * but not write files to disc.
     */

    public function testGenerateComplexTypes()
    {
        $output = [];
        $scriptSuccess = null;

        exec ($this->scriptCommand('generate-complex-datatypes'),$output,$scriptSuccess);
        $this->assertSame(0, $scriptSuccess);
    }

    public function testGenerateMethods()
    {
        $output = [];
        $scriptSuccess = null;
        exec ($this->scriptCommand('generate-methods'),$output,$scriptSuccess);
        $this->assertSame(0, $scriptSuccess);
    }

    private function scriptCommand($name)
    {
        $phpBin = exec('which php');

        if (!file_exists($phpBin) || !is_executable($phpBin)) {
            throw new \Exception('Could not determine PHP exec.');
        }

        return $phpBin . ' ' .  str_replace(
          'tests/CodeGenerators',
          'scripts/' . $name . '.php --no-file-generation',
          dirname(__FILE__)
        );
    }

}
