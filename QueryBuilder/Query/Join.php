<?php
namespace SlothMySql\QueryBuilder\Query;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\Query\ConstraintInterface;
use SlothMySql\Face\Query\JoinInterface;
use SlothMySql\Face\Value\TableInterface;

class Join implements JoinInterface
{
	use QueryElementTrait;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var TableInterface
	 */
	protected $table;

	/**
	 * @var string
	 */
	protected $alias;

	/**
	 * @var ConstraintInterface
	 */
	protected $constraint;

    public function __toString()
	{
		if ($this->alias !== null) {
			$tableString = sprintf('`%s` AS `%s`', $this->table->getTableName(), $this->alias);
		} else {
			$tableString = (string)$this->table;
		}
		return sprintf('%s JOIN %s ON (%s)', $this->type, $tableString, $this->constraint);
	}

	/**
	 * @param $type
	 * @return JoinInterface $this
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
	 * @param TableInterface $table
	 * @return JoinInterface $this
	 */
	public function table(TableInterface $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param string $alias
	 * @return JoinInterface $this
	 */
	public function withAlias($alias)
	{
		$this->alias = $alias;
		return $this;
	}

	/**
	 * @param ConstraintInterface $constraint
	 * @return JoinInterface $this
	 */
	public function on(ConstraintInterface $constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}
}