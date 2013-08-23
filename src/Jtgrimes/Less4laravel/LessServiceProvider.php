<?php namespace Jtgrimes\Less4laravel;

use Illuminate\Support\ServiceProvider;

class LessServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('jtgrimes/less4laravel');
		$this->app['less'] = $this->app->share(function($app)
		{
			$config = $app['config'];
			$builder = $app['html'];
			return new Less($config,$builder);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('less');
	}

}