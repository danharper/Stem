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

	/**
	 * Test Handlers are correctly registered
	 */

	public function testRunNumber()
	{
		$this->s->run(':number');
		$this->s->run(':int');
	}

	public function testRunDigit()
	{
		$this->s->run(':digit');
	}

	public function testRunString()
	{
		$this->s->run(':string');
		$this->s->run(':words');
	}

	public function testRunWord()
	{
		$this->s->run(':word');
	}

	public function testRunEmail()
	{
		$this->s->run(':email');
	}

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
