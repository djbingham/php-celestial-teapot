<?php
namespace SlothMySql\Abstractory\Query;

use SlothMySql\Abstractory\AQuery;
use SlothMySql\Abstractory\AValue;
use SlothMySql\Abstractory\Value\ATable;
use SlothMySql\Abstractory\Value\Table\AData;
use SlothMySql\Abstractory\Value\Table\AField;

abstract class AUpdate extends AQuery
{
	/**
	 * @param ATable $table
	 * @return $this
	 */
	abstract public function table(ATable $table);

	/**
	 * @param AField $field
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function set(AField $field, AValue $value);

	/**
	 * @return array
	 */
	abstract public function getFields();

	/**
	 * @return array
	 */
	abstract public function getValues();

	/**
	 * @param AData $tableData
	 * @return $this
	 * @throws \Exception
	 */
	abstract public function data(AData $tableData);

	/**
	 * @param AConstraint $constraint
	 * @return $this
	 */
	abstract public function where(AConstraint $constraint);
}
