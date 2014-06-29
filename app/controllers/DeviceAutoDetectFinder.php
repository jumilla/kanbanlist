<?php

use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class DeviceAutoDetectFinder extends FileViewFinder {

	public static function install()
	{
		$app = app();
		$app->bindShared('view.finder', function($app) {
			return new DeviceAutoDetectFinder($app->make('files'), Config::get('view.paths'));
		});

		$app->bindShared('view', function($app)
		{
			// Next we need to grab the engine resolver instance that will be used by the
			// environment. The resolver will be used by an environment to get each of
			// the various engine implementations such as plain PHP or Blade engine.
			$resolver = $app['view.engine.resolver'];

			$finder = $app['view.finder'];

			$env = new Factory($resolver, $finder, $app['events']);

			// We will also set the container instance on this view environment since the
			// view composers may be classes registered in the container, which allows
			// for great testable, flexible composers for the application developer.
			$env->setContainer($app);

			$env->share('app', $app);

			return $env;
		});
	}

	/**
	 * Get the fully qualified location of the view.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public /*override*/ function find($name)
	{
		Log::info('View Hook!! ' . $name);
		return parent::find($name);
	}

}
