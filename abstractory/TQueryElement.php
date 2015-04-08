<?php
namespace PHPMySql\Abstractory;

trait TQueryElement
{
	/**
	 * @var IConnection
	 */
	private $connection;

	abstract public function __toString();

	public function __construct(IConnection $connection)
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