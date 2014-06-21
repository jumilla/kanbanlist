<?php

// 
$localDatabaseFile = storage_path().'/database/local.sqlite';

if (!file_exists($localDatabaseFile)) {
	Log::info('Make Sqlite File "'.$localDatabaseFile.'"');
	file_put_contents($localDatabaseFile, '');
}
