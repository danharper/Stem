<?php namespace danharper\Stem\Type;

class Number
{

	public function run($max = null)
	{
		$max = $max ?: 290;
		return rand(1, $max);
	}

}