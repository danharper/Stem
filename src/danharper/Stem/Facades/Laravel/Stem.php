<?php namespace danharper\Stem\Facades\Laravel;

use Illuminate\Support\Facades\Facade;

class Stem extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'stem'; }

}