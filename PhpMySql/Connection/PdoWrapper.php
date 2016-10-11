<?php
namespace PhpMySql\Connection;

use PhpMySql\Face;

class PdoWrapper implements Face\ConnectionInterface
{
	/**
	 * @var \PDO
	 */
	private $pdoHandle;

	/**
	 * @var array
	 */
	private $queryLog = array();

	/**
	 * @var \PDOStatement
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

	public function __construct(\PDO $pdoHandle)
	{
		$this->pdoHandle = $pdoHandle;
	}

	public function begin($flags = null, $name = null)
	{
		$this->pdoHandle->beginTransaction();
		$this->logQuery('BEGIN');
		return $this;
	}

	public function commit($flags = null, $name = null)
	{
		$this->pdoHandle->commit();
		$this->logQuery('COMMIT');
		return $this;
	}

	public function rollback($flags = null, $name = null)
	{
		$this->pdoHandle->rollBack();
		$this->logQuery('ROLLBACK');
		return $this;
	}

	public function executeQuery(Face\QueryInterface $query)
	{
		$queryString = (string)$query;

		$this->logQuery($queryString);

		try {
			$result = $this->pdoHandle->query($queryString);

			if ($result instanceof \PDOStatement) {
				$this->handlePdoResult($result);
			} else {
				$this->handlePdoFail();
			}
		} catch (\PDOException $e) {
			$this->handlePdoFail();
		}

		return $this;
	}

	protected function handlePdoResult(\PDOStatement $result)
	{
		$this->lastError = false;
		$this->lastResult = $result;
		$this->lastResultData = $this->lastResult->fetchAll(\PDO::FETCH_ASSOC);
		$this->lastResult->closeCursor();
	}


	protected function handlePdoFail()
	{
		$this->lastError = $this->pdoHandle->errorInfo();
		$this->lastResult = false;
		$this->lastResultData = array();

		$queryLog = $this->getQueryLog();
		$lastQuery = $queryLog[count($queryLog) - 1];

		throw new \Exception(
			sprintf(
				'An error occurred executing a MySQL query: %s',
				json_encode(array(
					'Error' => $this->lastError,
					'Query' => $lastQuery
				))
			)
		);
	}

	public function getLastResultData()
	{
		return $this->lastResultData;
	}

	public function getLastInsertId()
	{
		return $this->pdoHandle->lastInsertId();
	}

	public function countAffectedRows()
	{
		$rowCount = 0;
		if ($this->lastResult instanceof \PDOStatement) {
			$rowCount = $this->lastResult->rowCount();
		}
		return $rowCount;
	}

	public function getQueryLog()
	{
		return $this->queryLog;
	}

	public function getLastError()
	{
		return $this->lastError;
	}

	public function escapeString($string)
	{
		// @todo: Remove the trim here and update the rest of the project to not wrap escaped strings in quotes.
		return trim($this->pdoHandle->quote($string), '\'');
	}

	protected function logQuery($queryString)
	{
		$this->queryLog[] = $queryString;
		return $this;
	}
}
