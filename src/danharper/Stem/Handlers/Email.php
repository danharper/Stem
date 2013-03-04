<?php namespace danharper\Stem\Handlers;

class Email extends String implements HandlerInterface
{

	public function register()
	{
		return 'email';
	}

	public function run($modifier = null)
	{
		$tlds = array('com', 'net', 'org');
		return $this->getWord() . rand() . '@' . $this->getWord() . '.example.' . $tlds[array_rand($tlds)];
	}

}