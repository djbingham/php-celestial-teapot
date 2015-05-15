<?php

namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;

class Constant extends MySqlValue
{
	public static $constants = array('NULL', 'CURRENT_TIMESTAMP');

	protected $value;

	public function __toString()
	{
		return sprintf('%s', $this->value);
	}

	/**
	 * @param string $constant
	 * @throws \Exception
	 */
	public function setValue($constant)
	{
        if (!is_string($constant)) {
            throw new \Exception('Invalid type specified for name of SQL constant');
        }
		$constant = strtoupper($constant);
		if (!in_array($constant, self::$constants)) {
			throw new \Exception('Invalid name specified for SQL constant');
		}
		$this->value = $constant;
	}
}