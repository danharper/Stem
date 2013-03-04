<?php

use \danharper\Stem\Stem;
use \Mockery as m;

class StemTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		$this->s = new Stem;
	}

	public function tearDown()
	{
		m::close();
	}

	public function testStart()
	{
		$this->assertInstanceOf('\danharper\Stem\Stem', $this->s);
	}

	public function testRegisterWithObject()
	{
		$text = 'lorem ipsum dolor';

		$object = m::mock('something')
			->shouldReceive('register')->once()
			->andReturn('foo')
			->shouldReceive('run')->once()->with(null)
			->andReturn($text)
			->mock();

		$this->s->register($object);
		$this->assertEquals($text, $this->s->run(':foo'));
	}

	public function testRegisterClosure()
	{
		$this->s->register(function() {
			return 'abc293';
		}, 'bar');

		$this->assertEquals('abc293', $this->s->run(':bar'));
	}

	public function testRunNormal()
	{
		$this->assertEquals('fizzbuzz', $this->s->run('fizzbuzz'));
	}

	/**
	 * @expectedException danharper\Stem\Exceptions\InvalidHandlerException
	 */
	public function testRunThrowsExceptionForInvalidTypes()
	{
		$this->s->run(':foobar');
	}

	public function testRunInt()
	{
		$this->assertInternalType('int', $this->s->run(':int'));
	}

	public function testRunIntCustomMax()
	{
		$this->assertLessThanOrEqual(2, $this->s->run('2:int'));
	}

	public function testRunDigit()
	{
		$made = $this->s->run(':digit');
		$this->assertInternalType('int', $made);
		$this->assertLessThanOrEqual(9, $made);
		$this->assertGreaterThanOrEqual(0, $made);
	}

	public function testString()
	{
		$made = $this->s->run(':string');
		$count = count(explode(' ', $made));
		$this->assertInternalType('string', $made);
		$this->assertGreaterThanOrEqual(2, $count);
		$this->assertLessThanOrEqual(24, $count);
	}

	public function testWord()
	{
		$made = $this->s->run(':word');
		$this->assertInternalType('string', $made);
		$this->assertCount(1, explode(' ', $made));
	}

	public function testWords()
	{
		$made = $this->s->run('9:words');
		$this->assertInternalType('string', $made);
		$this->assertCount(9, explode(' ', $made));
	}

	// public function testRegisterThrowsWhenEmptyArray()

	public function testAttributes()
	{
		$input = array(
			'id' => ':int',
			'title' => ':string',
			'created' => 'xjsijr'
		);

		$this->s->fixture('Job', $input);
		$output = $this->s->attributes('Job');

		$this->assertEquals(array_keys($input), array_keys($output));
	}

	public function testMake()
	{
		$input = array(
			'id' => ':int',
			'title' => ':string',
			'created' => 'xjsijr'
		);

		$this->s->fixture('FixtureStub', $input);
		$x = $this->s->make('FixtureStub');

		foreach (array_keys($input) as $key)
		{
			$this->assertTrue(property_exists($x, $key));
		}
	}

}

class FixtureStub {
	public function __construct($data)
	{
		foreach ($data as $key => $value) $this->$key = $value;
	}
}
