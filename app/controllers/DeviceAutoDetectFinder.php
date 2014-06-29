<?php

use Illuminate\View\FileViewFinder;

class DeviceAutoDetectFinder extends FileViewFinder {

	public static function install()
	{
		Log::info('View Hook install');

		App::bindShared('view.finder', function() {
			Log::info('Called');
			return new DeviceAutoDetectFinder(App::make('files'), Config::get('view.paths'));
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
	}

}
