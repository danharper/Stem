<?php

use \danharper\Stem\Handlers\Number;

/**
 * @group Handlers
 */
class NumberTest extends PHPUnit_Framework_TestCase
{

	public function testIsImplementsInterface()
	{
		$this->assertInstanceOf('\danharper\Stem\Handlers\HandlerInterface', new Number);
	}

	public function testRegisters()
	{
		$handler = new Number;
		$out = $handler->register();

		$this->assertCount(2, $out);
		$this->assertContains('number', $out);
		$this->assertContains('int', $out);
	}

	public function testRunReturnsNumber()
	{
		$handler = new Number;
		$this->assertInternalType('int', $handler->run());
		$this->assertGreaterThanOrEqual(0, $handler->run());
		$this->assertLessThanOrEqual(290, $handler->run());
	}

	public function testRunModifierLimitsMaxNumber()
	{
		$handler = new Number;
		$min = 0;
		$max = 1;
		$this->assertInternalType('int', $handler->run($max));
		$this->assertGreaterThanOrEqual($min, $handler->run($max));
		$this->assertLessThanOrEqual($max, $handler->run($max));
	}

	public function testRunGivesZeroWithModifierOfZero()
	{
		$handler = new Number;
		$min_max = 0;
		$this->assertEquals($min_max, $handler->run($min_max));
	}

}
