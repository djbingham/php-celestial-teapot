<?php
// Setup a database wrapper
$database = new SlothMySql\Connection\Database(array(
	'host' => 'localhost',
	'username' => 'slothMySqlDemoUser',
	'password' => 'slothMySqlD3m0P4ss',
	'name' => 'slothMySqlDemo',
	'port' => null,
	'socket' => null
));
$dbConnection = new SlothMySql\Connection\MySqli($database);
$queryBuilder = new SlothMySql\QueryBuilder\Wrapper($dbConnection);
$db = new SlothMySql\DatabaseWrapper($dbConnection, $queryBuilder);

// Example query construction and execution
$table1 = $db->value()->table('MyFirstTable');
$table2 = $db->value()->table('MySecondTable');
$sampleQuery = $db->query()
	->select()
	->field($table1->field('firstField')->setAlias('firstTableField'))
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