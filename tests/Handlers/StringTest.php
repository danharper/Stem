<?php

use \danharper\Stem\Handlers\String;

/**
 * @group Handlers
 */
class StringTest extends PHPUnit_Framework_TestCase
{

	public function testIsImplementsInterface()
	{
		$this->assertInstanceOf('\danharper\Stem\Handlers\HandlerInterface', new String);
	}

	public function testRegisters()
	{
		$handler = new String;
		$out = $handler->register();

		$this->assertCount(2, $out);
		$this->assertContains('string', $out);
		$this->assertContains('words', $out);
	}

	public function testRunReturnsString()
	{
		$handler = new String;
		$this->assertInternalType('string', $handler->run());
	}

	public function testRunReturnsAtLeastTwoWords()
	{
		$handler = new String;
		$this->assertGreaterThanOrEqual(2, count(explode(' ', $handler->run())));
	}

	public function testRunModifierReturnsCorrectNumberOfWords()
	{
		$handler = new String;
		$numWords = 1;
		for ($numWords=1; $numWords < 3; $numWords++) { 
			$result = $handler->run($numWords);
			$this->assertEquals($numWords, count(explode(' ', $result)));
		}
	}

	public function testRunModifierZeroReturnsEmptyString()
	{
		$handler = new String;
		$this->assertEquals('', $handler->run(0));
	}

}
