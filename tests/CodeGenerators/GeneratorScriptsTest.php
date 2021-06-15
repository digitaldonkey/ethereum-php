<?php
namespace Ethereum;

use PhpParser\Node\Scalar\String_;

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
        $this->deleteScripts('generate-complex-datatypes');
        exec ($this->scriptCommand('generate-complex-datatypes'),$output,$scriptSuccess);
        $this->assertSame(0, $scriptSuccess, 'Generated scripts sucessfully');
        $this->assertTrue($this->checkGitNotModified(), 'Generated files match git commit');
    }

    public function testGenerateMethods()
    {
        $output = [];
        $scriptSuccess = null;
        $this->deleteScripts('generate-methods');
        exec ($this->scriptCommand('generate-methods'),$output,$scriptSuccess);
        $this->assertSame(0, $scriptSuccess, 'Generated scripts sucessfully');
        $this->assertTrue($this->checkGitNotModified(), 'Generated files match git commit');
    }

    private function checkGitNotModified() : bool {
        $output = [];
        $scriptSuccess = null;
        exec ('git status --porcelain',$output,$scriptSuccess);
        return $scriptSuccess === 0 && empty($output);
    }

    private function deleteScripts(string $type)
    {
        $root = __DIR__ . '/../../';
        if ($type === 'generate-methods') {
            unlink($root . 'src/Web3Interface.php');
            unlink($root . 'src/Web3Methods.php');
        }
        if ($type === 'generate-complex-datatypes') {
            $schema = json_decode(file_get_contents($root . "resources/ethjs-schema.json"), true);
            $names = array_keys($schema['objects']);
            foreach ($names as $name) {
                unlink($root . 'src/DataType/' . ucfirst($name) . '.php');
            }
        }
    }

    private function scriptCommand($name)
    {
        $phpBin = exec('which php');

        if (!file_exists($phpBin) || !is_executable($phpBin)) {
            throw new \Exception('Could not determine PHP exec.');
        }

        return $phpBin . ' ' .  str_replace(
          'tests/CodeGenerators',
          'scripts/' . $name . '.php',
          dirname(__FILE__)
        );
    }

}
