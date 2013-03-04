<?php

use \danharper\Stem\Facades\Native\Stem;

class NativeTest extends PHPUnit_Framework_TestCase
{

	public function testFacade()
	{
		$input = array(
			'id' => ':int',
		);

		Stem::fixture('Job', $input);
		$output = Stem::attributes('Job');

		$this->assertEquals(array_keys($input), array_keys($output));
		$this->assertInternalType('int', $output['id']);
	}

}
