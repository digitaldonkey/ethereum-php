<?php
namespace Ethereum;

/**
 * @defgroup tests Tests
 *
 * %Ethereum bas test class.
 */

/**
 * @defgroup staticTests Static Tests
 * @ingroup tests
 *
 * Testing anything which can be tested without %Ethereum running.
 */


// PHPUnit 6 introduced a breaking change that
// removed PHPUnit_Framework_TestCase as a base class,
// and replaced it with \PHPUnit\Framework\TestCase
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');
}


/**
 * Abstract base class for Tests
 *
 * @ingroup staticTests
 */
abstract class TestStatic extends \PHPUnit_Framework_TestCase {}
