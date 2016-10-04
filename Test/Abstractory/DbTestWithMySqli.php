<?php
namespace SlothMySql\Test\Abstractory;

use PDO;

abstract class DbTestWithMySqli extends \PHPUnit_Extensions_Database_TestCase
{
	use Mocker;

	/**
	 * @var PDO
	 */
	static private $pdo = null;
	private $conn = null;

	abstract protected function prepareTables();

	public function getConnection()
	{
		if ($this->conn === null) {
			if (self::$pdo == null) {
				self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);

				$this->executeDbQuery('CREATE DATABASE IF NOT EXISTS `slothMySqlTest`')
					->executeDbQuery('USE `slothMySqlTest`');

				$this->prepareTables();
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_NAME']);
		}

		return $this->conn;
	}

	protected function executeDbQuery($query)
	{
		if (self::$pdo->query($query) === false) {
			$error = self::$pdo->errorInfo();
			throw new \Exception(sprintf('Database query failed: %s', $error[2]));
		}
		return $this;
	}

	protected function insertData($tableName, array $fields, array $values)
	{
		$query = 'INSERT INTO `%s` (`%s`) VALUES %s';
		$valueStrings = array();
		foreach ($values as $row) {
			$valueStrings[] = sprintf('("%s")', implode('", "', array_values($row)));
		}
		$query = sprintf($query, $tableName, implode('`, `', $fields), implode(', ', $valueStrings));
		if (self::$pdo->query($query) === false) {
			$error = array_pop(self::$pdo->errorInfo());
			throw new \Exception(sprintf('Failed to insert into table `%s` (with query: %s). Error: %s', $tableName, $query, $error));
		}
		return $this;
	}

	/**
	 * Check whether a record exists containing given values for specific fields.
	 * This doesn't necessarily have to contain all fields from the table.
	 *
	 * @param string $tableName
	 * @param array $data
	 * @return Boolean
	 * @throws \Exception on failure to check database for existence of data
	 */
	protected function recordExists($tableName, array $data)
	{
		$conditions = array();
		foreach ($data as $field => $value) {
			$conditions[] = sprintf('`%s` = "%s"', $field, $value);
		}
		$query = sprintf('SELECT COUNT(*) FROM `%s` WHERE %s', $tableName, implode(' AND ', $conditions));
		$result = self::$pdo->query($query);
		if ($result === false) {
			$error = array_pop(self::$pdo->errorInfo());
			throw new \Exception(sprintf('Failed to select from table `%s` (with query: %s). Error: %s', $tableName, $query, $error));
		}

		$existingRecords = $result->fetchAll();
		$result->closeCursor();

		return array_shift($existingRecords) > 0;
	}
}