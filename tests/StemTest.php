<?php

use \danharper\Stem\Stem;
use \Mockery as m;

class TestFixtureClass {
	public function __construct($data)
	{
		foreach ($data as $key => $value) $this->$key = $value;
	}
}

class StemTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		$this->s = new Stem(array(
			new \danharper\Stem\Handlers\Number,
			new \danharper\Stem\Handlers\Digit,
			new \danharper\Stem\Handlers\String,
			new \danharper\Stem\Handlers\Word,
		));
	}

	public function tearDown()
	{
		m::close();
	}

	public function testStart()
	{
		$this->assertInstanceOf('\danharper\Stem\Stem', $this->s);
	}

	public function testFacade()
	{
		$input = array(
			'id' => ':int',
		);

		\danharper\Stem\Facades\Native\Stem::fixture('Job', $input);
		$output = \danharper\Stem\Facades\Native\Stem::attributes('Job');

		$this->assertEquals(array_keys($input), array_keys($output));
	}

	public function testAttributesA()
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

	public function testGetHandlers()
	{
		$s = new Stem;
		$out = $s->getHandlers();
		$this->assertInternalType('array', $out);
		$this->assertCount(0, $out);
	}

	public function testRegisterWithObject()
	{
		$object = m::mock('something')
			->shouldReceive('register')->once()
			->andReturn('foo')
			->mock();

		$this->s->register($object);
		$handlers = $this->s->getHandlers();

		$this->assertEquals($object, $handlers['foo']);
	}

	public function testRegisterClosure()
	{
		$this->s->register(function() {
			return 'abc293';
		}, 'foo');

		$this->assertEquals('abc293', $this->s->run(':foo'));
	}

	public function testMake()
	{
		$input = array(
			'id' => ':int',
			'title' => ':string',
			'created' => 'xjsijr'
		);

		$this->s->fixture('TestFixtureClass', $input);
		$x = $this->s->make('TestFixtureClass');

		foreach (array_keys($input) as $key)
		{
			$this->assertTrue(property_exists($x, $key));
		}
	}

	public function testRunNormal()
	{
		$this->assertEquals('string', $this->s->run('string'));
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

}
