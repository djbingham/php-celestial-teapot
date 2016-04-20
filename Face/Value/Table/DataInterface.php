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
	 * @return mixed
	 */
	function getNullValue();

	/**
	 * @param integer $index
	 * @return $this
	 */
	function beginRow($index = null);

	/**
	 * @return integer
	 */
	function getCurrentRowIndex();

	/**
	 * @param FieldInterface $field
	 * @param ValueInterface $value
	 * @return $this
	 */
	function set(FieldInterface $field, ValueInterface $value);

	/**
	 * @return array
	 */
	function getCurrentRow();

	/**
	 * @return $this
	 */
	function endRow();

	/**
	 * @return array
	 */
	function getFields();

	/**
	 * @return array
	 */
	function getRows();
}
