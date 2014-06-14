<?php

return array(

	'default' => 'sqlite',

	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => __DIR__.'/../../database/local.sqlite',
			'prefix'   => '',
		),

		'mysql' => array(
			'host'      => 'localhost',
			'database'  => 'kanbanlist_dev',
			'username'  => 'laravellers',
			'password'  => 'laravellers',
			'prefix'    => '',
		),

		'pgsql' => array(
			'host'     => 'localhost',
			'database' => 'kanbanlist_dev',
			'username' => 'laravellers',
			'password' => 'laravellers',
			'prefix'   => '',
			'schema'   => 'public',
		),

	),

);
