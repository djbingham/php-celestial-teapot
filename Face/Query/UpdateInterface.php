<?php
namespace SlothMySql\Face\Query;

use SlothMySql\Face\QueryInterface;
use SlothMySql\Face\ValueInterface;
use SlothMySql\Face\Value\TableInterface;
use SlothMySql\Face\Value\Table\DataInterface;
use SlothMySql\Face\Value\Table\FieldInterface;

interface UpdateInterface extends QueryInterface
{
	/**
	 * @param TableInterface $table
	 * @return $this
	 */
	public function table(TableInterface $table);

	/**
	 * @param FieldInterface $field
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function set(FieldInterface $field, ValueInterface $value);

	/**
	 * @return array
	 */
	public function getFields();

	/**
	 * @return array
	 */
	public function getValues();

	/**
	 * @param DataInterface $tableData
	 * @return $this
	 * @throws \Exception
	 */
	public function data(DataInterface $tableData);

	/**
	 * @param ConstraintInterface $constraint
	 * @return $this
	 */
	public function where(ConstraintInterface $constraint);
}
