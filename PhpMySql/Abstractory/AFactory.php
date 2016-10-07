<?php
namespace PhpMySql\Abstractory;

use PhpMySql\Base\InternalCache;
use PhpMySql\Face\ConnectionInterface;

abstract class AFactory
{
	use InternalCache;

	/**
	 * @var ConnectionInterface
	 */
	protected $connection;

	public function __construct(ConnectionInterface $connection)
	{
		$this->connection = $connection;
	}
}
