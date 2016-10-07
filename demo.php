<?php
// Setup a database wrapper
$pdo = new \PDO('mysql:host=database;dbname=test_db', 'test_user', 'test_pass');
$pdoWrapper = new PhpMySql\Connection\PdoWrapper($pdo);
$queryBuilder = new PhpMySql\QueryBuilder\Wrapper($pdoWrapper);
$db = new PhpMySql\DatabaseWrapper($pdoWrapper, $queryBuilder);

// Example query construction
$table1 = $db->value()->table('MyFirstTable');
$table2 = $db->value()->table('MySecondTable');
$sampleQuery = $db->query()
	->select()
	->field($table1->field('firstField')->setAlias('firstTableField'))
	->from($table1)
	->join($db->join()->inner()
		->table($table2)
		->withAlias('MySecondTableAlias')
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

// Example query execution
$sampleResult = $db->execute($sampleQuery)->getData();