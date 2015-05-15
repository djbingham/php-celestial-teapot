<?php
namespace SlothMySql\QueryBuilder\Query;

use SlothMySql\QueryBuilder\Abstractory\MySqlQuery;
use SlothMySql\QueryBuilder\Value;
use SlothMySql\QueryBuilder\Query;

class Join extends MySqlQuery
{
	const TYPE_INNER = 'INNER';
	const TYPE_OUTER = 'OUTER';
	const TYPE_LEFT = 'LEFT';
	const TYPE_RIGHT = 'RIGHT';

	protected $type;
	protected $table;
	protected $constraint;

    public function __toString()
	{
		return sprintf('%s JOIN %s ON (%s)', $this->type, $this->table, $this->constraint);
	}

	/**
	 * @param $type
	 * @return Join $this
	 * @throws \Exception
	 */
	public function setType($type)
	{
		$type = strtoupper($type);
		if (!in_array($type, array(self::TYPE_INNER, self::TYPE_OUTER, self::TYPE_LEFT, self::TYPE_RIGHT))) {
			throw new \Exception('Invalid join type specified');
		}
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param Value\Table $table
	 * @return Join $this
	 */
	public function table(Value\Table $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param Query\Constraint $constraint
	 * @return Join $this
	 */
	public function on(Query\Constraint $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}
}