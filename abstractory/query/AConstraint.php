<?php
namespace PHPMySql\Abstractory\Query;

use PHPMySql\Abstractory\AValue;
use PHPMySql\Abstractory\Value\AValueList;
use PHPMySql\Abstractory\TQueryElement;

abstract class AConstraint
{
	use TQueryElement;

	/**
	 * @return $this
	 */
	abstract public function wrap();

	/**
	 * @return bool
	 */
	abstract public function isWrapped();

	/**
	 * @param AValue $subject
	 * @return $this
	 */
	abstract public function setSubject(AValue $subject);

	/**
	 * @return AValue
	 */
	abstract public function getSubject();

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function equals(AValue $value);

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function notEquals(AValue $value);

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function greaterThan(AValue $value);

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function greaterThanOrEquals(AValue $value);

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function lessThan(AValue $value);

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function lessThanOrEquals(AValue $value);

	/**
	 * @param AValueList $values
	 * @return $this
	 */
	abstract public function in(AValueList $values);

	/**
	 * @param AValue $values
	 * @return $this
	 */
	abstract public function notIn(AValue $values);

	/**
	 * @param $operator
	 * @return $this
	 * @throws \Exception
	 */
	abstract public function setComparator($operator);

	/**
	 * @return string
	 */
	abstract public function getComparator();

	/**
	 * @param AValue $value
	 * @return $this
	 */
	abstract public function setValue(AValue $value);

	/**
	 * @return AValue
	 */
	abstract public function getValue();

	/**
	 * @param AConstraint $condition
	 * @return $this
	 */
	abstract public function andWhere(AConstraint $condition);

	/**
	 * @param AConstraint $condition
	 * @return $this
	 */
	abstract public function andOn(AConstraint $condition);

	/**
	 * @param AConstraint $condition
	 * @return $this
	 */
	abstract public function orWhere(AConstraint $condition);

	/**
	 * @param AConstraint $condition
	 * @return $this
	 */
	abstract public function orOn(AConstraint $condition);

	/**
	 * @param array $simultaneousConstraints
	 * @return $this
	 */
	abstract public function setSimultaneousConstraints($simultaneousConstraints);

	/**
	 * @return array
	 */
	abstract public function getSimultaneousConstraints();

	/**
	 * @return bool
	 */
	abstract public function hasSimultaneousConstraints();

	/**
	 * @param array $alternativeConstraints
	 * @return $this
	 */
	abstract public function setAlternativeConstraints($alternativeConstraints);

	/**
	 * @return array
	 */
	abstract public function getAlternativeConstraints();

	/**
	 * @return bool
	 */
	abstract public function hasAlternativeConstraints();
}