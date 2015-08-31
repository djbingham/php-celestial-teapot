<?php
namespace SlothMySql\Face;

use SlothMySql\Abstractory\Query;

interface JoinFactoryInterface
{
	/**
	 * @return \SlothMySql\Face\Query\JoinInterface
	 */
	public function outer();

	/**
	 * @return \SlothMySql\Face\Query\JoinInterface
	 */
	public function inner();

	/**
	 * @return \SlothMySql\Face\Query\JoinInterface
	 */
	public function left();

	/**
	 * @return \SlothMySql\Face\Query\JoinInterface
	 */
	public function right();
}