<?php
namespace SlothMySql\Face\Query;

use SlothMySql\Face\QueryElementInterface;
use SlothMySql\Face\ValueInterface;
use SlothMySql\Face\Value\ValueListInterface;

interface ConstraintInterface extends QueryElementInterface
{
	/**
	 * @return $this
	 */
	public function wrap();

	/**
	 * @return bool
	 */
	public function isWrapped();

	/**
	 * @param ValueInterface $subject
	 * @return $this
	 */
	public function setSubject(ValueInterface $subject);

	/**
	 * @return ValueInterface
	 */
	public function getSubject();

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function equals(ValueInterface $value);

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function notEquals(ValueInterface $value);

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function greaterThan(ValueInterface $value);

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function greaterThanOrEquals(ValueInterface $value);

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function lessThan(ValueInterface $value);

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function lessThanOrEquals(ValueInterface $value);

	/**
	 * @param ValueListInterface $values
	 * @return $this
	 */
	public function in(ValueListInterface $values);

	/**
	 * @param ValueInterface $values
	 * @return $this
	 */
	public function notIn(ValueInterface $values);

	/**
	 * @param $operator
	 * @return $this
	 * @throws \Exception
	 */
	public function setComparator($operator);

	/**
	 * @return string
	 */
	public function getComparator();

	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	public function setValue(ValueInterface $value);

	/**
	 * @return ValueInterface
	 */
	public function getValue();

	/**
	 * @param ConstraintInterface $condition
	 * @return $this
	 */
	public function andWhere(ConstraintInterface $condition);

	/**
	 * @param ConstraintInterface $condition
	 * @return $this
	 */
	public function andOn(ConstraintInterface $condition);

	/**
	 * @param ConstraintInterface $condition
	 * @return $this
	 */
	public function orWhere(ConstraintInterface $condition);

	/**
	 * @param ConstraintInterface $condition
	 * @return $this
	 */
	public function orOn(ConstraintInterface $condition);

	/**
	 * @param array $simultaneousConstraints
	 * @return $this
	 */
	public function setSimultaneousConstraints($simultaneousConstraints);

	/**
	 * @return array
	 */
	public function getSimultaneousConstraints();

	/**
	 * @return bool
	 */
	public function hasSimultaneousConstraints();

	/**
	 * @param array $alternativeConstraints
	 * @return $this
	 */
	public function setAlternativeConstraints($alternativeConstraints);

	/**
	 * @return array
	 */
	public function getAlternativeConstraints();

	/**
	 * @return bool
	 */
	public function hasAlternativeConstraints();
}