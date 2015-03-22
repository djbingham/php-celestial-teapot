<?php

namespace PHPMySql\Connector\Connection;

use PHPMySql\Abstractory\ConnectionWrapper;
use PHPMySql\Connector\ConnectionOptions;
use PHPMySql\Abstractory\Query;

class MySqli extends ConnectionWrapper
{
	/**
	 * @var string
	 */
	protected $host;
	/**
	 * @var string
	 */
	protected $username;
	/**
	 * @var string
	 */
	protected $password;
	/**
	 * @var string
	 */
	protected $databaseName;
	/**
	 * @var int
	 */
	protected $port = null;
	/**
	 * @var int
	 */
	protected $socket = null;
	/**
	 * @var \MySqli
	 */
	protected $engine;
	/**
	 * @var ConnectionOptions
	 */
	protected $options;
	/**
	 * @var array Log of query strings
	 */
	protected $queryLog = array();
	/**
	 * @var \MySqli_Result Result object from last query (if any)
	 */
	protected $result = false;
	/**
	 * @var array Data returned by last query (if any)
	 */
	protected $resultData = false;
	/**
	 * @var mixed
	 */
	protected $insertId;
	/**
	 * @var int
	 */
	protected $affectedRowsCount;
	/**
	 * @var string Error returned by last query (if any)
	 */
	protected $error = false;

	/**
	 * @param \MySqli $engine
	 * @return $this
	 */
	public function setEngine($engine)
	{
		$this->engine = $engine;
		return $this;
	}

	public function getEngine()
	{
		return $this->engine;
	}

	public function setOptions(ConnectionOptions $options)
	{
		$this->options = $options;
		return $this;
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function getQueryLog()
	{
		return $this->queryLog;
	}

	/**
	 * @return ConnectionWrapper $this
	 * @throws \Exception
	 */
	public function connect()
	{
		if (count($errors = $this->getOptions()->errors())) {
			throw new \Exception("Invalid connector databaseWrapper.\nErrors: " . implode(",\n", $errors));
		}
		else {
			$this->getEngine()->connect(
				$this->getOptions()->getHost(),
				$this->getOptions()->getUsername(),
				$this->getOptions()->getPassword(),
				$this->getOptions()->getDatabaseName(),
				$this->getOptions()->getPort(),
				$this->getOptions()->getSocket()
			);
		}
		return $this;
	}

	/**
	 * @param Query $query
	 * @return ConnectionWrapper $this
	 */
	public function query(Query $query)
	{
		$queryString = (string)$query;
		$engine = $this->getEngine();
		$this->logQuery($queryString);

		$success = $engine->real_query($queryString);

		if ($success) {
			$this->result = $engine->store_result();
			$this->error = false;
		} else {
			$this->result = false;
			$this->error = mysqli_error($engine);
			if ($this->error === '') {
				$this->error = false;
			}
		}

		if ($this->error === false) {
			$this->insertId = $engine->insert_id;
			$this->affectedRowsCount = $engine->affected_rows;
			if ($this->result instanceof \MySqli_Result) {
				$this->resultData = $this->result->fetch_all(MYSQLI_ASSOC);
				$this->result->free();
			} else {
				$this->resultData = null;
			}
		} else {
			$this->resultData = null;
			$this->insertId = null;
			$this->affectedRowsCount = null;
		}

		return $this;
	}

	protected function logQuery($queryString)
	{
		$this->queryLog[] = $queryString;
		return $this;
	}

	public function begin()
	{
		$this->getEngine()->autocommit(false);
		$this->logQuery('BEGIN');
		return $this;
	}

	public function commit()
	{
		$this->getEngine()->commit();
		$this->logQuery('COMMIT');
		$this->getEngine()->autocommit(true);
		return $this;
	}

	public function rollback()
	{
		$this->getEngine()->rollback();
		$this->logQuery('ROLLBACK');
		$this->getEngine()->autocommit(true);
		return $this;
	}

	public function getData()
	{
		return $this->resultData;
	}

	public function getInsertId()
	{
		return $this->insertId;
	}

	public function getAffectedRowsCount()
	{
		return $this->affectedRowsCount;
	}

	public function hasError()
	{
		return $this->error !== false;
	}

	public function getError()
	{
		return $this->error;
	}

	public function escapeString($string)
	{
		return $this->getEngine()->real_escape_string($string);
	}
}
