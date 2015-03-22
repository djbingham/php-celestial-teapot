<?php

namespace PHPMySql\Factory;

use PHPMySql\Abstractory;
use PHPMySql\Factory;

/**
 * SubFactory
 * @package PHPFramework\Factory\Database
 */
abstract class SubFactory extends Abstractory\Factory
{
	/**
	 * @var Factory
	 */
	protected $database;

	public function __construct(Factory $database)
	{
		$this->database = $database;
	}
}
