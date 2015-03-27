<?php
namespace PHPMySql\Test;

abstract class DbTest extends UnitTest
{
	private $dbHost = 'localhost';
	private $dbName = 'phpMySqlTest';
	private $dbUsername = 'phpMySqlTestUser';
	private $dbPassword = 'phpMySqlT3stP4ss';
	private $mySqli;

	public function __construct()
	{
		$this->getMySqli();
		$this->resetDatabase($this->dbName);
	}

	public function __destruct()
	{
		$this->dropDatabase($this->dbName);
		$this->getMySqli()->close();
	}

	protected function getMySqli()
	{
		if (is_null($this->mySqli)) {
			$this->mySqli = new \MySqli($this->dbHost, $this->dbUsername, $this->dbPassword);
			if (mysqli_connect_errno()) {
				throw new \Exception(sprintf('MySqli failed to connect: %s', mysqli_connect_error()));
			}
		}
		return $this->mySqli;
	}

	private function resetDatabase($databaseName)
	{
		$this->dropDatabase($databaseName);
		$this->createDatabase($databaseName);
		$this->selectDatabase($databaseName);
	}

	private function dropDatabase($databaseName)
	{
		$query = sprintf('DROP DATABASE IF EXISTS %s', $databaseName);
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to drop database (with query: %s). Error: %s', $query, $error));
		}
		return $this;
	}

	private function createDatabase($databaseName)
	{
		$query = sprintf('CREATE DATABASE IF NOT EXISTS %s', $databaseName);
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to create database (with query: %s). Error: %s', $query, $error));
		}
		return $this;
	}

	private function selectDatabase($databaseName)
	{
		$query = sprintf('USE %s', $databaseName);
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to select database (with query: %s). Error: %s', $query, $error));
		}
		return $this;
	}

	protected function createTable($tableName, $fields)
	{
		$query = sprintf('CREATE TABLE `%s` (%s)', $tableName, implode('), (', $fields));
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to create table `%s` (with query: %s). Error: %s', $tableName, $query, $error));
		}
		return $this;
	}

	protected function dropTable($tableName)
	{
		$query = sprintf('DROP TABLE IF EXISTS `%s`', $tableName);
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to drop table `%s` (with query: %s). Error: %s', $tableName, $query, $error));
		}
		return $this;
	}

	protected function truncateTable($tableName)
	{
		$query = sprintf('TRUNCATE TABLE `%s`', $tableName);
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to truncate table `%s` (with query: %s). Error: %s', $tableName, $query, $error));
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
		if (!$this->getMySqli()->query($query)) {
			$error = mysqli_error($this->getMySqli());
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
		$result = $this->getMySqli()->query($query);
		if (!$result) {
			$error = mysqli_error($this->getMySqli());
			throw new \Exception(sprintf('Failed to select from table `%s` (with query: %s). Error: %s', $tableName, $query, $error));
		}

		$existingRecords = $result->fetch_assoc();
		$result->close();

		return array_shift($existingRecords) > 0;
	}
}