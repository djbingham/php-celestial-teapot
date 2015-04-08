<?php
namespace PHPMySql\Abstractory\Query;

use PHPMySql\Abstractory\AQuery;
use PHPMySql\Abstractory\Value\ATable;
use PHPMySql\Abstractory\Value\Table\AData;

abstract class AInsert extends AQuery
{
	const INSERT = 'INSERT';
	const REPLACE = 'REPLACE';

	/**
	 * Change this query to replace existing rows with the same primary key
	 * @return $this
	 */
	abstract public function replaceRows();

	/**
	 * @param ATable $table
	 * @return $this
	 */
	abstract public function into(ATable $table);

	/**
	 * @param AData $data
	 * @return $this
	 */
	abstract public function data(AData $data);
}
