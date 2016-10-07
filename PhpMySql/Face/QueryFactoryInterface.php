<?php
namespace PhpMySql\Face;

use PhpMySql\Abstractory\Query;

interface QueryFactoryInterface
{
	/**
	 * @return \PhpMySql\Face\Query\SelectInterface
	 */
	public function select();

	/**
	 * @return \PhpMySql\Face\Query\InsertInterface
	 */
	public function insert();

	/**
	 * @return \PhpMySql\Face\Query\InsertInterface
	 */
	public function replace();

	/**
	 * @return \PhpMySql\Face\Query\UpdateInterface
	 */
	public function update();

	/**
	 * @return \PhpMySql\Face\Query\DeleteInterface
	 */
	public function delete();

	/**
	 * @return JoinFactoryInterface
	 */
	public function join();

	/**
	 * @return \PhpMySql\Face\Query\ConstraintInterface
	 */
	public function constraint();
}