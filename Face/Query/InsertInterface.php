<?php
namespace SlothMySql\Face\Query;

use SlothMySql\Face\QueryInterface;
use SlothMySql\Face\Value\TableInterface;
use SlothMySql\Face\Value\Table\DataInterface;

interface InsertInterface extends QueryInterface
{
	const INSERT = 'INSERT';
	const REPLACE = 'REPLACE';

	/**
	 * Change this query to replace existing rows with the same primary key
	 * @return $this
	 */
	public function replaceRows();

	/**
	 * @param TableInterface $table
	 * @return $this
	 */
	public function into(TableInterface $table);

	/**
	 * @param DataInterface $data
	 * @return $this
	 */
	public function data(DataInterface $data);
}
