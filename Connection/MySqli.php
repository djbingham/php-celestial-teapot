<?php
namespace SlothMySql\Connection;

use SlothMySql\Abstractory;
use SlothMySql\Face;

class MySqli extends \MySqli implements Face\ConnectionInterface
{
	/**
	 * @var array
	 */
	private $queryLog = array();

	/**
	 * @var \mysqli_result
	 */
	private $lastResult;

	/**
	 * @var array
	 */
	private $lastResultData = array();

	/**
	 * @var string
	 */
	private $lastError;

	public function executeQuery(Face\QueryInterface $query)
	{
		$queryString = (string)$query;
		$this->logQuery($queryString);

		$success = $this->real_query($queryString);

		if ($success) {
			$this->lastResult = $this->store_result();
			if ($this->lastResult instanceof \MySqli_Result) {
				$this->lastResultData = $this->lastResult->fetch_all(MYSQLI_ASSOC);
				$this->lastResult->free();
			}
			$this->lastError = false;
		} else {
			$this->lastResult = false;
			$this->lastResultData = array();
			$this->lastError = mysqli_error($this);
			throw new \Exception(
				sprintf(
					"An error occurred executing a MySQL query.\r\n\r\nMySqli error: %s\r\n\r\nQuery: %s",
					$this->lastError,
					$queryString
				)
			);
		}

		return $this;
	}

	public function getLastResultData()
	{
		return $this->lastResultData;
	}

	public function getLastInsertId()
	{
		return $this->insert_id;
	}

	public function countAffectedRows()
	{
		return $this->affected_rows;
	}

	public function getQueryLog()
	{
		return $this->queryLog;
	}

	public function begin($flags = null, $name = null)
	{
		$this->autocommit(false);
		$this->logQuery('BEGIN');
		return $this;
	}

	public function commit($flags = null, $name = null)
	{
		parent::commit($flags, $name);
		$this->autocommit(true);
		$this->logQuery('COMMIT');
		return $this;
	}

	public function rollback($flags = null, $name = null)
	{
		$this->autocommit(true);
		$this->logQuery('ROLLBACK');
		return $this;
	}

	public function getLastError()
	{
		return $this->lastError;
	}

	public function escapeString($string)
	{
		return $this->real_escape_string($string);
	}

	protected function logQuery($queryString)
	{
		$this->queryLog[] = $queryString;
		return $this;
	}
}