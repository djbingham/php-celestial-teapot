<?php
namespace SlothMySql\QueryBuilder\Query;

use SlothMySql\QueryBuilder\Abstractory\MySqlValue;
use SlothMySql\QueryBuilder\Value\ValueList;

class Constraint
{
	/**
	 * @var MySqlValue
	 */
	protected $subject;
	/**
	 * @var string
	 */
	protected $comparator;
	/**
	 * @var MySqlValue
	 */
	protected $value;
	/**
	 * @var bool
	 */
	protected $wrap; // Whether to wrap this constraint in braces during __toString
	/**
	 * @var array
	 */
	protected $simultaneousConstraints = array(); // Conditions to append with 'AND'
	/**
	 * @var array
	 */
	protected $alternativeConstraints = array(); // Conditions to append with 'OR'

	/**
	 * @return mixed
	 */
	public function __toString()
	{
		$queryString = $this->buildConstraintString();
		$queryString = $this->applySimultaneousToString($queryString);
		$queryString = $this->applyAlternativesToString($queryString);
		if ($this->wrap) {
			return sprintf('(%s)', $queryString);
		}
		return $queryString;
	}

	protected function buildConstraintString()
	{
		$queryString = sprintf('%s %s %s', $this->subject, $this->comparator, $this->value);
		return $queryString;
	}

	protected function applySimultaneousToString($queryString)
	{
		if (!empty($this->simultaneousConstraints)) {
			foreach ($this->simultaneousConstraints as $constraint) {
				$queryString .= "\nAND " . (string) $constraint;
			}
		}
		return $queryString;
	}

	protected function applyAlternativesToString($queryString)
	{
		if (!empty($this->alternativeConstraints)) {
			foreach ($this->alternativeConstraints as $constraint) {
				$queryString .= "\nOR " . (string) $constraint;
			}
		}
		return $queryString;
	}

	/**
	 * @return Constraint
	 */
	public function wrap()
	{
		$this->wrap = true;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isWrapped()
	{
		return $this->wrap;
	}

	/**
	 * @param MySqlValue $subject
	 * @return Constraint $this
	 */
	public function setSubject(MySqlValue $subject)
	{
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @return MySqlValue
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function equals(MySqlValue $value)
	{
		$this->setComparator('=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function notEquals(MySqlValue $value)
	{
		$this->setComparator('!=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function greaterThan(MySqlValue $value)
	{
		$this->setComparator('>');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function greaterThanOrEquals(MySqlValue $value)
	{
		$this->setComparator('>=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function lessThan(MySqlValue $value)
	{
		$this->setComparator('<');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function lessThanOrEquals(MySqlValue $value)
	{
		$this->setComparator('<=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueList $values
	 * @return Constraint $this
	 */
	public function in(ValueList $values)
	{
		$this->setComparator('IN');
		$this->setValue($values);
		return $this;
	}

	/**
	 * @param MySqlValue $values
	 * @return Constraint $this
	 */
	public function notIn(MySqlValue $values)
	{
		$this->setComparator('NOT IN');
		$this->setValue($values);
		return $this;
	}

    /**
     * @param MySqlValue $value
     * @return $this
     */
    public function like(MySqlValue $value)
    {
        $this->setComparator('LIKE');
        $this->setValue($value);
        return $this;
    }

	/**
	 * @param $operator
	 * @return Constraint $this
	 * @throws \Exception
	 */
	public function setComparator($operator)
	{
		if (!in_array($operator, array('=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'LIKE'))) {
			throw new \Exception('Invalid comparison operator in MySql constraint');
		}
		$this->comparator = $operator;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getComparator()
	{
		return $this->comparator;
	}

	/**
	 * @param MySqlValue $value
	 * @return Constraint $this
	 */
	public function setValue(MySqlValue $value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * @return MySqlValue
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param Constraint $condition
	 * @return Constraint $this
	 */
	public function andWhere(Constraint $condition)
	{
		$this->simultaneousConstraints[] = $condition;
		return $this;
	}

	/**
	 * @param Constraint $condition
	 * @return Constraint $this
	 */
	public function andOn(Constraint $condition)
	{
		return $this->andWhere($condition);
	}

	/**
	 * @param Constraint $condition
	 * @return Constraint $this
	 */
	public function orWhere(Constraint $condition)
	{
		$this->alternativeConstraints[] = $condition;
		return $this;
	}

	/**
	 * @param Constraint $condition
	 * @return Constraint $this
	 */
	public function orOn(Constraint $condition)
	{
		return $this->orWhere($condition);
	}

	/**
	 * @param array $simultaneousConstraints
	 * @return Constraint $this
	 */
	public function setSimultaneousConstraints($simultaneousConstraints)
	{
		$this->simultaneousConstraints = $simultaneousConstraints;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getSimultaneousConstraints()
	{
		return $this->simultaneousConstraints;
	}

	/**
	 * @return bool
	 */
	public function hasSimultaneousConstraints()
	{
		return !empty($this->simultaneousConstraints);
	}

	/**
	 * @param array $alternativeConstraints
	 * @return Constraint $this
	 */
	public function setAlternativeConstraints($alternativeConstraints)
	{
		$this->alternativeConstraints = $alternativeConstraints;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getAlternativeConstraints()
	{
		return $this->alternativeConstraints;
	}

	/**
	 * @return bool
	 */
	public function hasAlternativeConstraints()
	{
		return !empty($this->alternativeConstraints);
	}
}