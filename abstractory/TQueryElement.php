<?php
namespace PHPMySql\Abstractory;

trait TQueryElement
{
	/**
	 * @var IConnection
	 */
	private $connection;

	public function __construct($connection)
	{
		$this->connection = $connection;
	}

	protected function escapeString($string)
	{
		return $this->connection->escapeString($string);
	}
}