<?php

namespace Ethereum;

// PHPUnit 6 introduced a breaking change that
// removed PHPUnit_Framework_TestCase as a base class,
// and replaced it with \PHPUnit\Framework\TestCase
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase'))
class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');

abstract class EthTest extends \PHPUnit_Framework_TestCase {}
