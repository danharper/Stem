<?php namespace danharper\Stem\Handlers;

class Word extends String implements HandlerInterface
{

	public function register()
	{
		return 'word';
	}

	public function run($modifier = null)
	{
		return $this->getWord();
	}

}