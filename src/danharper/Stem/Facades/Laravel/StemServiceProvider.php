<?php namespace danharper\Stem\Facades\Laravel;

use danharper\Stem\Stem;
use Illuminate\Support\ServiceProvider;

class StemServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('danharper/stem', 'danharper/stem');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['stem'] = $this->app->share(function($app)
		{
			return new Stem;
		});
	}

}