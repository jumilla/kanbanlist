<?php

return array(

	'default' => 'sqlite',

	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => storage_path() . '/database/local.sqlite',
			'prefix'   => '',
		),

		'mysql' => array(
			'host'      => 'localhost',
			'database'  => 'kanbanlist',
			'username'  => 'laravelers',
			'password'  => 'laravelers',
			'prefix'    => '',
		),

		'pgsql' => array(
			'host'     => 'localhost',
			'database' => 'kanbanlist',
			'username' => 'laravelers',
			'password' => 'laravelers',
			'prefix'   => '',
			'schema'   => 'public',
		),

	),

);
