<?php
namespace SlothMySql\Abstractory\Value\Table;

use SlothMySql\Abstractory\AValue;
use SlothMySql\Abstractory\Value\ATable;

abstract class AField extends AValue
{
	/**
	 * @param ATable $table
	 * @return $this
	 */
	abstract public function setTable(ATable $table);

	/**
	 * @param $fieldName
	 * @return $this
	 */
	abstract public function setFieldName($fieldName);

    /**
     * @param $alias
     * @return $this
     */
    abstract public function setAlias($alias);
}