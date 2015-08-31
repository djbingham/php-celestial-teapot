<?php
namespace SlothMySql\Face;

use SlothMySql\Abstractory\Query;

interface QueryFactoryInterface
{
	/**
	 * @return \SlothMySql\Face\Query\SelectInterface
	 */
	public function select();

	/**
	 * @return \SlothMySql\Face\Query\InsertInterface
	 */
	public function insert();

	/**
	 * @return \SlothMySql\Face\Query\InsertInterface
	 */
	public function replace();

	/**
	 * @return \SlothMySql\Face\Query\UpdateInterface
	 */
	public function update();

	/**
	 * @return \SlothMySql\Face\Query\DeleteInterface
	 */
	public function delete();

	/**
	 * @return JoinFactoryInterface
	 */
	public function join();

	/**
	 * @return \SlothMySql\Face\Query\ConstraintInterface
	 */
	public function constraint();
}