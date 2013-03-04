<?php namespace danharper\Stem;

use danharper\Stem\Exceptions\InvalidHandlerException;

class Stem {

	protected $fixtures = array();
	protected $handlers = array();

	public function __construct($registers = array())
	{
		$this->registerDefaultHandlers();

		foreach ($registers as $object)
		{
			$this->register($object);
		}
	}

	private function registerDefaultHandlers()
	{
		$defaults = array(
			new \danharper\Stem\Handlers\Number,
			new \danharper\Stem\Handlers\Digit,
			new \danharper\Stem\Handlers\String,
			new \danharper\Stem\Handlers\Word,
			new \danharper\Stem\Handlers\Email,
		);

		foreach ($defaults as $h) $this->register($h);
	}

	public function register($object, $keys = null)
	{
		if ( ! is_callable($object))
		{
			$keys = $object->register();
		}

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

	protected function bind($key, $object)
	{
		$this->handlers[$key] = $object;
	}

	public function fixture($fixtureName, array $attributes)
	{
		$this->fixtures[$fixtureName] = $attributes;
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

		$handler = $this->handlers[$type];

		if (is_callable($handler))
		{
			return call_user_func($handler, $modifier);
		}

		return $handler->run($modifier);
	}

	public function attributes($fixtureName)
	{
		$fixtureAttributes = $this->fixtures[$fixtureName];
		$stem = $this;

		return array_map(function($type) use ($stem) {
			return $stem->run($type);
		}, $fixtureAttributes);
	}

	public function make($fixtureName)
	{
		return new $fixtureName($this->attributes($fixtureName));
	}

}
