<?php

use \danharper\Stem\Handlers\Word;

/**
 * @group Handlers
 */
class WordTest extends PHPUnit_Framework_TestCase
{

	public function testIsImplementsInterface()
	{
		$this->assertInstanceOf('\danharper\Stem\Handlers\HandlerInterface', new Word);
	}

	public function testRegisters()
	{
		$handler = new Word;
		$this->assertEquals('word', $handler->register());
	}

	public function testRunReturnsString()
	{
		$handler = new Word;
		$this->assertInternalType('string', $handler->run());
	}

	public function testRunReturnsSingleWord()
	{
		$handler = new Word;
		$this->assertNotContains(' ', $handler->run());
	}

}
