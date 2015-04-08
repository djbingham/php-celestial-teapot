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


// Setup a database wrapper using connection and query builder managers
$dbManager = new PHPMySql\Manager(null, null);
$dbManager->setConnection('default', new PHPMySql\Connection\MySqli($databases['default']));
$dbManager->setQueryBuilder('default', new PHPMySql\QueryBuilder\MySql\Wrapper($dbManager->getConnection('default')));
$db = new PHPMySql\DatabaseWrapper($dbManager->getConnection('default'), $dbManager->getQueryBuilder('mysql'));

// Setup a database wrapper without using manager classes
$dbConnection = new PHPMySql\Connection\MySqli($databases['default']);
$db = new PHPMySql\DatabaseWrapper($dbConnection, new PHPMySql\QueryBuilder\MySql\Wrapper($dbConnection));

// Example query construction and execution
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