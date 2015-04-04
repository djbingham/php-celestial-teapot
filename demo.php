<?php
$databases = array(
	'default' => new PHPMySql\Connection\Database(array(
		'host' => 'localhost',
		'username' => 'phpMySqlDemoUser',
		'password' => 'phpMySqlD3m0P4ss',
		'name' => 'phpMySqlDemo',
		'port' => null,
		'socket' => null
	))
);
$connectionManager = new PHPMySql\Connection\Manager();
$connectionManager->set('mysqliDefault', new PHPMySql\Connection\MySqli($databases['default']));

$queryBuilderManager = new PHPMySql\QueryBuilder\Manager();
$queryBuilderManager->set('mysql', new PHPMySql\QueryBuilder\MySql\Factory($connectionManager->get('default')));

$db = new PHPMySql\DatabaseWrapper($connectionManager->get('default'), $queryBuilderManager->get('mysql'));

$table1 = $db->value()->table('MyFirstTable');
$table2 = $db->value()->table('MySecondTable');

$sampleQuery = $db->query()
	->select()
	->field($table1->field('firstField'))
	->from($table1)
	->join($db->query()->join()->inner()
		->table($table2)
		->on($db->query()->constraint()
			->setSubject($table1->field('id'))
			->equals($table2->field('id'))
		)
	)
	->where($db->query()->constraint()
		->setSubject($table1->field('dateCreated'))
		->greaterThan($db->value()->sqlFunction('NOW'))
	)
	->orderBy($table1->field('dateCreated'));
$sampleResult = $db->execute($sampleQuery)->getData();



// IGNORE BELOW
$phpMySql = new PHPMySql\Manager($connectionManager, $queryBuilderManager);
$phpMySql->set('default', array(
	'connection' => 'mysqliDefault',
	'queryBuilder' => 'mysql'
));