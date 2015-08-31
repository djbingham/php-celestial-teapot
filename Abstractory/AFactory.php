<?php
namespace SlothMySql\Abstractory;

use SlothMySql\Base\InternalCache;
use SlothMySql\Face\ConnectionInterface;

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
