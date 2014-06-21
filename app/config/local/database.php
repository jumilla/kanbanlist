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
			'username'  => 'laravellers',
			'password'  => 'laravellers',
			'prefix'    => '',
		),

		'pgsql' => array(
			'host'     => 'localhost',
			'database' => 'kanbanlist',
			'username' => 'laravellers',
			'password' => 'laravellers',
			'prefix'   => '',
			'schema'   => 'public',
		),

	),

);
