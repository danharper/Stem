<?php namespace danharper\Stem\Handlers;

class Digit implements HandlerInterface
{

	public function register()
	{
		return 'digit';
	}

	public function run($modifier = null)
	{
		return rand(0, 9);
	}

}