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

		$x = $this->getWord() . rand() . '@' . $this->getWord() . '.example.' . $tlds[array_rand($tlds)];
		echo "\r\n$x\r\n";
		return $x;
	}

}