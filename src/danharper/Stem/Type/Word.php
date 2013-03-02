<?php namespace danharper\Stem\Type;

class Word extends String
{

	public function run()
	{
		return $this->getWord();
	}

}