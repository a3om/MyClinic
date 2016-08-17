#!/usr/bin/php
<?php

$clinics = [1, 2, 3, 4, 5, 54, 140, 777];
$syncFolders = ['app'];

foreach ($clinics as $id)
{
	/*
		- Выполняем подключение к базе данных
	*/

	try
	{
		$dbh = new PDO('mysql:host=localhost;dbname=lefipro_' . $id, 'root', '4e3836c15b');
	}
	catch (Exception $ex)
	{
		echo $ex->getMessage() . "\r\n";
		continue;
	}

	/*
		- Выполняем запросы к базе данных
	*/

	$dbh->query('UPDATE `clinics` SET `language` = \'ru\' WHERE 1 LIMIT 1');

	/*
		- Отключаемся от базы данных
	*/
	
	$dbh = null;

	/*
		- Обновляем файлы
	*/

	foreach ($syncFolders as $folder)
	{
		`cp {$folder} ../{$id}.lefipro.ru/ -R`;
		`chmod 777 -R ../{$id}.lefipro.ru/app/storage`;
		`chmod 777 -R ../{$id}.lefipro.ru/app/storage/views`;
		`chmod 777 -R ../{$id}.lefipro.ru/app/storage/logs`;
		`chmod 777 -R ../{$id}.lefipro.ru/app/storage/sessions`;
	}

	/*
		- Выводим сообщение о результатах
	*/

	echo 'Клиника ' . $id . ' была обновлена' . "\r\n";
}