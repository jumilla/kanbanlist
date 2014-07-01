<?php

use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class DeviceAutoDetectFinder extends FileViewFinder {

	public static function install($app)
	{
		$app->bindShared('view.finder', function($app) {
			return new DeviceAutoDetectFinder($app->make('files'), $app->make('config')->get('view.paths'));
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
//		Log::info('View Hook!! ' . $name);
		if (Agent::isMobile()) {
			try {
				return parent::find($name.'@phone');
			}
			catch (Exception $e) {
			Log::debug(__METHOD__.": not find {$name}@phone");
			}
		}

		return parent::find($name);
	}

}
