<?php

use \danharper\Stem\Handlers\Digit;

/**
 * @group Handlers
 */
class DigitTest extends PHPUnit_Framework_TestCase
{

	public function testIsImplementsInterface()
	{
		$this->assertInstanceOf('\danharper\Stem\Handlers\HandlerInterface', new Digit);
	}

	public function testRegistersAsDigit()
	{
		$h = new Digit;
		$this->assertEquals('digit', $h->register());
	}

	public function testRunReturnsSingleDigit()
	{
		$h = new Digit;
		$this->assertGreaterThanOrEqual(0, $h->run());
		$this->assertLessThanOrEqual(9, $h->run());
	}

}
