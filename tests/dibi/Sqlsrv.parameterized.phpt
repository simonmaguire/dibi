<?php

/**
 * @dataProvider ../databases.ini sqlsrv
 */

declare(strict_types=1);

use Dibi\DateTime;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$conn = new Dibi\Connection($config + ['generalizedQuery'=>true]);
$conn->loadFile(__DIR__ . "/data/sqlsrv.sql");


//Query with %f mod -- I CANT succesffully query orders 
$res = $conn->query('SELECT * FROM dbo.orders');
Assert::equal(7.0,
	$res->fetch()['amount']);


//Query with %f mod -- I CANT succesffully query orders 
$res = $conn->query('SELECT * FROM dbo.orders WHERE amount=%f', 7.0);
Assert::equal(new Dibi\Row(['order_id' => 1, 'customer_id' => 2,'product_id' => 1,'amount' => 7]),
	$res->fetch());

//Query with LIKE mods 
//$res = $conn->query('SELECT * FROM [customers] WHERE name LIKE %like~', 'Dave');
//Assert::equal(new Dibi\Row([
//	'customer_id' => 1,
//	'name' => 'Dave Lister',
//]), $res->fetch());



//Query with %s and $i mods 
$res = $conn->query('SELECT * FROM [customers] WHERE customer_id=%i AND name=%s', 1, 'Dave Lister');
Assert::equal(new Dibi\Row([
	'customer_id' => 1,
	'name' => 'Dave Lister',
]), $res->fetch());


//Query without params 
$res = $conn->query('SELECT * FROM [customers]');
Assert::equal(new Dibi\Row([
	'customer_id' => 1,
	'name' => 'Dave Lister',
]), $res->fetch());


//Go through and remove array indexes and change those with 1 to the new get param func
Assert::same('SELECT * FROM [table] WHERE id=? AND name=?' ,
	$conn->translate('SELECT * FROM [table] WHERE id=%i AND name=%s', 10, 'ahoj')[0]
);


Assert::same(['10', 'ahoj'] ,
	$conn->translate('SELECT * FROM [table] WHERE id=%i AND name=%s', 10, 'ahoj')[1]
);


Assert::same('SELECT * FROM [table] WHERE col=?' ,
	$conn->translate('SELECT * FROM [table] WHERE col=%b', True)[0]
);


Assert::same(['1'] ,
	$conn->translate('SELECT * FROM [table] WHERE col=%b', True)[1]
);

