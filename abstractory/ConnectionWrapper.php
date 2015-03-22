<?php

namespace PHPMySql\Abstractory;

abstract class ConnectionWrapper
{
	/**
	 * Open a database connection for this wrapper
	 * @return ConnectionWrapper $this
	 */
	abstract public function connect();

	/**
	 * Execute a query on the database
	 * @param Query $query
	 * @return ConnectionWrapper $this
	 */
	abstract public function query(Query $query);

	/**
	 * Begin a transaction
	 * @return ConnectionWrapper $this;
	 */
	abstract public function begin();

	/**
	 * Commit all queries in the current transaction
	 * @return ConnectionWrapper $this;
	 */
	abstract public function commit();

	/**
	 * Abort the current transaction
	 * @return ConnectionWrapper $this;
	 */
	abstract public function rollback();

	/**
	 * Fetch data returned by the most recently execute query
	 * @return array
	 */
	abstract public function getData();

	/**
	 * Return the number of rows affected by the last query
	 * @return int
	 */
	abstract public function getAffectedRowsCount();

	/**
	 * Return the ID of the last row inserted in the current database session
	 * @return int
	 */
	abstract public function getInsertId();

	/**
	 * Return whether the last query caused an error
	 * @return boolean
	 */
	abstract public function hasError();

	/**
	 * Return the error (if any) caused by the last query
	 * @return string|null
	 */
	abstract public function getError();

	/**
	 * Return a log of query strings run on this wrapper's connection
	 * @return array
	 */
	abstract public function getQueryLog();

	/**
	 * Escape a given string, ready for use in a query
	 * @param string $string String to escape
	 * @return string The escaped string
	 */
	abstract public function escapeString($string);
}
