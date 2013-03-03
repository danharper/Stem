<?php namespace danharper\Stem\Facades\Native;

use danharper\Stem\Stem as RealStem;

class Stem
{

	protected static $instance;

	public static function instance()
	{
		if (static::$instance === null)
		{
			static::$instance = new RealStem();
		}

		return static::$instance;
	}

	public static function __callStatic($method, $args)
	{
		$instance = static::instance();

		switch (count($args))
		{
			case 0:
				return $instance->$method();

			case 1:
				return $instance->$method($args[0]);

			case 2:
				return $instance->$method($args[0], $args[1]);

			case 3:
				return $instance->$method($args[0], $args[1], $args[2]);

			case 4:
				return $instance->$method($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array(array($instance, $method), $args);
		}
	}

}
