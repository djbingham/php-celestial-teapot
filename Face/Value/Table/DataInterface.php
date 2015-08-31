<?php
namespace SlothMySql\Face\Value\Table;

use SlothMySql\Face\ValueInterface;

interface DataInterface
{
	/**
	 * @param ValueInterface $value
	 * @return $this
	 */
	function setNullValue(ValueInterface $value);

	/**
	 * @return $this
	 */
	function getNullValue();

	/**
	 * @param integer $index
	 * @return $this
	 */
	function beginRow($index = null);

	/**
	 * @return $this
	 */
	function getCurrentRowIndex();

	/**
	 * @param FieldInterface $field
	 * @param ValueInterface $value
	 * @return $this
	 */
	function set(FieldInterface $field, ValueInterface $value);

	/**
	 * @return $this
	 */
	function getCurrentRow();

	/**
	 * @return $this
	 */
	function endRow();

	/**
	 * @return $this
	 */
	function getFields();

	/**
	 * @return $this
	 */
	function getRows();
}
