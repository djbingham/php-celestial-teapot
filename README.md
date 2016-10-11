# PHP-MySQL
This project aims to provide a PHP query builder that allows PHP code to closely resemble MySQL, whilst automatically sanitising all values inputted to the query builder.

## Example Usage
```
$pdo = new \PDO('sqlite::memory:');
$pdoWrapper = new PhpMySql\Connection\PdoWrapper($pdo);
$queryBuilder = new PhpMySql\QueryBuilder\Wrapper($pdoWrapper);
$db = new PhpMySql\DatabaseWrapper($pdoWrapper, $queryBuilder);

$selectQuery = $db->query()
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

$db->execute($selectQuery);

$fetchedData = $db->getData();
```

## Planned Improvements
* Convert to use prepared statements
* Allow table names, field names and query parameters to be given as string values, rather than class instances, for convenience

## Gotchas

### Update Data
When building the data object for update queries, all fields used must not have a table set as this will cause `table.field = value` to be inserted into the query, which is invalid. Without a table name set on the field, this will become `field = value`, which is valid and fine as an update can only be run against a single table anyway.