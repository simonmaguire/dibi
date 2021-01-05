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




//Query with sN and iN mods 
$res = $conn->query('SELECT * FROM [customers] WHERE name = %sN AND customer_id = %iN', 'Dave Lister', 1);
Assert::equal(1, count($res->fetchAll()));



//Query with LIKE mods 
$res = $conn->query('SELECT * FROM [customers] WHERE name LIKE %like~', 'Dave');
Assert::equal(1, count($res->fetchAll()));


//Query with %f mod
$res = $conn->query('SELECT * FROM dbo.orders WHERE amount=%f', 2.0);
Assert::equal(2.0,
	$res->fetch()['amount']);


//%dt
$res = $conn->query('SELECT * FROM dbo.orders WHERE order_date>%dt', (string) new DateTime('2019-04-01') );
Assert::equal(4,
	count($res->fetchAll()));

//%d
$res = $conn->query('SELECT * FROM [orders] WHERE order_date>%d', '2020-2-2');
Assert::same(2 ,
	count($res->fetchAll())
);


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


Assert::same('SELECT * FROM [table] WHERE id=? AND name=?' ,
	$conn->translate('SELECT * FROM [table] WHERE id=%i AND name=%s', 10, 'ahoj')['translation']
);


Assert::same(['10', 'ahoj'] ,
	$conn->translate('SELECT * FROM [table] WHERE id=%i AND name=%s', 10, 'ahoj')['parameters']
);


Assert::same('SELECT * FROM [table] WHERE col=?' ,
	$conn->translate('SELECT * FROM [table] WHERE col=%b', True)['translation']
);


Assert::same(['1'] ,
	$conn->translate('SELECT * FROM [table] WHERE col=%b', True)['parameters']
);

