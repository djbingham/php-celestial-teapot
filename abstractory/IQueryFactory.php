<?php
namespace PHPMySql\Abstractory;

interface IQueryFactory
{
	/**
	 * @return Query\ASelect
	 */
	public function select();

	/**
	 * @return Query\AInsert
	 */
	public function insert();

	/**
	 * @return Query\AInsert
	 */
	public function replace();

	/**
	 * @return Query\AUpdate
	 */
	public function update();

	/**
	 * @return Query\ADelete
	 */
	public function delete();

	/**
	 * @return IJoinFactory
	 */
	public function join();

	/**
	 * @return Query\AConstraint
	 */
	public function constraint();
}