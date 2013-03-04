<?php namespace danharper\Stem\Handlers;

class Number implements HandlerInterface
{

	const MAX_NUMBER = 290;

	public function register()
	{
		return array('int', 'number');
	}

	public function run($max = null)
	{
		// note for screencast:
		// was originall:
		// $max = $max ?: 290;
		// however when setting max to 0, should give only 0
		// but the loose conditional causes it to default to 290
		$max = $max !== null ? $max : self::MAX_NUMBER;
		return rand(0, $max);
	}

}