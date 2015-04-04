<?php
namespace PHPMySql\Abstractory;

interface IQueryBuilderFactory
{
	/**
	 * @return Query
	 */
	public function query();

	/**
	 * @return Value
	 */
	public function value();
}