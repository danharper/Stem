<?php namespace danharper\Stem\Handlers;

class String implements HandlerInterface
{
	public function __construct()
	{
		$this->dictionary = include(__DIR__.'/../words.php');
	}

	public function register()
	{
		return array('string', 'words');
	}

	public function run($numWords = null)
	{
		// string is between 2 and 24 words
		// screencast note: same issue as in number
		$numWords = $numWords !== null ? $numWords : rand(2, 24);
		return $this->getWords($numWords);
	}

	protected function getWords($numWords = 2)
	{
		$words = array();
		for ($i = 0; $i < $numWords; $i++) { 
			$words[] = $this->getWord();
		}

		return implode(' ', $words);
	}

	protected function getWord()
	{
		$rand = array_rand($this->dictionary);
		return $this->dictionary[$rand];
	}

}