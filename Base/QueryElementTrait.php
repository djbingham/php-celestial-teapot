<?php
namespace SlothMySql\Base;

use SlothMySql\Face\ConnectionInterface;

trait QueryElementTrait
{
	/**
	 * @var ConnectionInterface
	 */
	private $connection;

	abstract public function __toString();

	public function __construct(ConnectionInterface $connection)
	{
		$this->connection = $connection;
	}

	protected function getConnection()
	{
		return $this->connection;
	}

	protected function escapeString($string)
	{
		return $this->connection->escapeString($string);
	}
}