<?php
namespace SlothMySql\Face;

interface QueryBuilderFactoryInterface
{
	/**
	 * @return QueryFactoryInterface
	 */
	public function query();

	/**
	 * @return ValueFactoryInterface
	 */
	public function value();
}