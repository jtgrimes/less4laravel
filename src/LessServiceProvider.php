<?php namespace Jtgrimes\Less4laravel;

use Collective\Html\HtmlBuilder;
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
		$this->app['less'] = $this->app->share(function($app)
		{
			$config = $app['config'];
            if (isset($app['html'])) {
                $builder = $app['html'];
            } else {
                // if the app hasn't set up Laravel's HTML package, we'd better just instantiate a version
                $builder = new HtmlBuilder($app['url']);
            }
			return new Less($config, $builder);
		});
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('less4laravel.php'),
        ]);
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
