<?php
namespace PhpMySql\QueryBuilder\Query;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\Query\ConstraintInterface;
use PhpMySql\Face\Value\ValueListInterface;
use PhpMySql\Face\ValueInterface;

class Constraint implements ConstraintInterface
{
	use QueryElementTrait;

	/**
	 * @var ValueInterface
	 */
	protected $subject;
	/**
	 * @var string
	 */
	protected $comparator;
	/**
	 * @var ValueInterface
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
		$queryString = $this->buildConstraintInterfaceString();
		$queryString = $this->applySimultaneousToString($queryString);
		$queryString = $this->applyAlternativesToString($queryString);
		if ($this->wrap) {
			return sprintf('(%s)', $queryString);
		}
		return $queryString;
	}

	protected function buildConstraintInterfaceString()
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
	 * @return ConstraintInterface
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
	 * @param ValueInterface $subject
	 * @return ConstraintInterface $this
	 */
	public function setSubject(ValueInterface $subject)
	{
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @return ValueInterface
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function equals(ValueInterface $value)
	{
		$this->setComparator('=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function notEquals(ValueInterface $value)
	{
		$this->setComparator('!=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function greaterThan(ValueInterface $value)
	{
		$this->setComparator('>');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function greaterThanOrEquals(ValueInterface $value)
	{
		$this->setComparator('>=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function lessThan(ValueInterface $value)
	{
		$this->setComparator('<');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function lessThanOrEquals(ValueInterface $value)
	{
		$this->setComparator('<=');
		$this->setValue($value);
		return $this;
	}

	/**
	 * @param ValueListInterface $values
	 * @return ConstraintInterface $this
	 */
	public function in(ValueListInterface $values)
	{
		$this->setComparator('IN');
		$this->setValue($values);
		return $this;
	}

	/**
	 * @param ValueInterface $values
	 * @return ConstraintInterface $this
	 */
	public function notIn(ValueInterface $values)
	{
		$this->setComparator('NOT IN');
		$this->setValue($values);
		return $this;
	}

    /**
     * @param ValueInterface $value
     * @return $this
     */
    public function like(ValueInterface $value)
    {
        $this->setComparator('LIKE');
        $this->setValue($value);
        return $this;
    }

    /**
     * @param ValueInterface $value
     * @return $this
     */
    public function is(ValueInterface $value)
    {
        $this->setComparator('IS');
        $this->setValue($value);
        return $this;
    }

	/**
	 * @param $operator
	 * @return ConstraintInterface $this
	 * @throws \Exception
	 */
	public function setComparator($operator)
	{
		if (!in_array($operator, array('=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'LIKE', 'IS'))) {
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
	 * @param ValueInterface $value
	 * @return ConstraintInterface $this
	 */
	public function setValue(ValueInterface $value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * @return ValueInterface
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param ConstraintInterface $condition
	 * @return ConstraintInterface $this
	 */
	public function andWhere(ConstraintInterface $condition)
	{
		$this->simultaneousConstraints[] = $condition;
		return $this;
	}

	/**
	 * @param ConstraintInterface $condition
	 * @return ConstraintInterface $this
	 */
	public function andOn(ConstraintInterface $condition)
	{
		return $this->andWhere($condition);
	}

	/**
	 * @param ConstraintInterface $condition
	 * @return ConstraintInterface $this
	 */
	public function orWhere(ConstraintInterface $condition)
	{
		$this->alternativeConstraints[] = $condition;
		return $this;
	}

	/**
	 * @param ConstraintInterface $condition
	 * @return ConstraintInterface $this
	 */
	public function orOn(ConstraintInterface $condition)
	{
		return $this->orWhere($condition);
	}

	/**
	 * @param array $simultaneousConstraints
	 * @return ConstraintInterface $this
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
	 * @return ConstraintInterface $this
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