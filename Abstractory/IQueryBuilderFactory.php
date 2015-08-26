<?php
namespace SlothMySql\Abstractory;

interface IQueryBuilderFactory
{
	/**
	 * @return IQueryFactory
	 */
	public function query();

	/**
	 * @return IValueFactory
	 */
	public function value();
}