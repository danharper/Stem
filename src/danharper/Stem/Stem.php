<?php namespace danharper\Stem;

class Stem {

	protected static $fixtures = array();
	protected static $handlers = array();

	public function __construct()
	{
		$registers = array(
			'danharper\Stem\Type\Number' => array('int', 'number'),
			'danharper\Stem\Type\Digit' => 'digit',
			'danharper\Stem\Type\String' => array('string', 'words'),
			'danharper\Stem\Type\Word' => 'word',
			'danharper\Stem\Type\Say' => 'say',
		);

		foreach ($registers as $class => $type)
		{
			self::register($class, $type);
		}
	}

	public static function register($className, $type)
	{
		if (is_array($type))
		{
			foreach ($type as $t)
			{
				self::register($className, $t);
			}
		}
		else
		{
			static::$handlers[$type] = $className;
		}
	}

	public static function fixture($fixtureName, array $attributes)
	{
		self::$fixtures[$fixtureName] = $attributes;
	}

	public static function attributes($fixtureName)
	{
		$attributes = self::$fixtures[$fixtureName];

		$r = array();

		foreach ($attributes as $attribute => $type)
		{
			$r[$attribute] = static::run($type);
		}

		return $r;
	}

	public static function run($type)
	{
		if (preg_match('/:/', $type))
		{
			list($modifier, $type) = explode(':', $type);
		}
		else
		{
			// no : then just return text
			return $type;
		}

		if ( ! $modifier) $modifier = null;

		if ( ! array_key_exists($type, self::$handlers))
		{
			throw new InvalidHandlerException("$type is not a valid handler");
		}

		$handlerName = self::$handlers[$type];

		if (is_object($handlerName))
		{
			return call_user_func($handlerName, $modifier);
		}

		if ( ! class_exists($handlerName))
		{
			throw new InvalidHandlerException("$handlerName is not defined");
		}

		if ( ! method_exists($handlerName, 'run'))
		{
			throw new InvalidHandlerException("$handlerName::run() does not exist");
		}

		$handler = new $handlerName;
		return $handler->run($modifier);
	}

}

class InvalidHandlerException extends \Exception {}
