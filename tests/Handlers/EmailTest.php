<?php

use \danharper\Stem\Handlers\Email;

/**
 * @group Handlers
 */
class EmailTest extends PHPUnit_Framework_TestCase
{

	public function testIsImplementsInterface()
	{
		$this->assertInstanceOf('\danharper\Stem\Handlers\HandlerInterface', new Email);
	}

	public function testRegisters()
	{
		$handler = new Email;
		$this->assertEquals('email', $handler->register());
	}

	public function testRunReturnsString()
	{
		$handler = new Email;
		$this->assertInternalType('string', $handler->run());
	}

	public function testRunReturnsUniqueExampleEmail()
	{
		$handler = new Email;
		$this->assertRegExp('/(\w+)@([a-zA-Z]+).example.(com|net|org)$/', $handler->run());
	}

}
