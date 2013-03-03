<?php

use \danharper\Stem\Stem as s;

class TestFixtureClass {
	public function __construct($data)
	{
		foreach ($data as $key => $value) $this->$key = $value;
	}
}

class StemTest extends PHPUnit_Framework_TestCase {

	public function testStart()
	{
		$this->assertInstanceOf('\danharper\Stem\Stem', new s);
	}

	public function testAttributesA()
	{
		$input = array(
			'id' => ':int',
			'title' => ':string',
			'created' => 'xjsijr'
		);

		s::fixture('Job', $input);
		$x = s::attributes('Job');

		$this->assertEquals(array_keys($input), array_keys($x));
	}

	public function testRegisterClosure()
	{
		s::register(function($input) {
			return 'abc293';
		}, 'foo');

		$this->assertEquals('abc293', s::run(':foo'));
	}

	public function testRunNormal()
	{
		$this->assertEquals('string', s::run('string'));
	}

	public function testRunInt()
	{
		$this->assertInternalType('int', s::run(':int'));
	}

	public function testRunIntCustomMax()
	{
		$this->assertLessThanOrEqual(2, s::run('2:int'));
	}

	public function testRunDigit()
	{
		$made = s::run(':digit');
		$this->assertInternalType('int', $made);
		$this->assertLessThanOrEqual(9, $made);
		$this->assertGreaterThanOrEqual(0, $made);
	}

	public function testString()
	{
		$made = s::run(':string');
		$count = count(explode(' ', $made));
		$this->assertInternalType('string', $made);
		$this->assertGreaterThanOrEqual(2, $count);
		$this->assertLessThanOrEqual(24, $count);
	}

	public function testWord()
	{
		$made = s::run(':word');
		$this->assertInternalType('string', $made);
		$this->assertCount(1, explode(' ', $made));
	}

	public function testWords()
	{
		$made = s::run('9:words');
		$this->assertInternalType('string', $made);
		$this->assertCount(9, explode(' ', $made));
	}

	// public function testRegisterThrowsWhenEmptyArray()

}
