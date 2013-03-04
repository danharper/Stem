<?php namespace danharper\Stem;

class Stem {

	protected $fixtures = array();
	protected $handlers = array();

	public function __construct()
	{
		$registers = array(
			'danharper\Stem\Handlers\Number' => array('int', 'number'),
			'danharper\Stem\Handlers\Digit' => 'digit',
			'danharper\Stem\Handlers\String' => array('string', 'words'),
			'danharper\Stem\Handlers\Word' => 'word',
			'danharper\Stem\Handlers\Say' => 'say',
		);

		foreach ($registers as $class => $type)
		{
			// $this->register($class, $type);
		}
	}

	public function register($object)
	{
		$keys = $object->register();

		if (is_array($keys))
		{
			foreach ($keys as $key) {
				$this->bind($key, $object);
			}
		}
		else
		{
			$this->bind($keys, $object);
		}

		return $keys;
	}

	public function getHandlers()
	{
		return $this->handlers;
	}

	protected function bind($key, $object)
	{
		$this->handlers[$key] = $object;
	}

	// public function register($className, $type)
	// {
	// 	if (is_array($type))
	// 	{
	// 		foreach ($type as $t)
	// 		{
	// 			$this->register($className, $t);
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$this->handlers[$type] = $className;
	// 	}
	// }

	public function fixture($fixtureName, array $attributes)
	{
		$this->fixtures[$fixtureName] = $attributes;
	}

	public function attributes($fixtureName)
	{
		$attributes = $this->fixtures[$fixtureName];

		$r = array();

		foreach ($attributes as $attribute => $type)
		{
			$r[$attribute] = $this->run($type);
		}

		return $r;
	}

	public function make($fixtureName)
	{
		return new $fixtureName($this->attributes($fixtureName));
	}

	public function run($type)
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

		if ( ! array_key_exists($type, $this->handlers))
		{
			throw new InvalidHandlerException("$type is not a valid handler");
		}

		$handlerName = $this->handlers[$type];

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
