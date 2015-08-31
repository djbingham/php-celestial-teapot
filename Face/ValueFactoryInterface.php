<?php
namespace SlothMySql\Face;

interface ValueFactoryInterface
{
	/**
	 * @param $string
	 * @return ValueInterface
	 */
	public function string($string);

	/**
	 * @param $number
	 * @return ValueInterface
	 */
	public function number($number);

	/**
	 * @param $constant
	 * @return ValueInterface
	 */
	public function sqlConstant($constant);

	/**
	 * @param $function
	 * @param array $params
	 * @return ValueInterface
	 */
	public function sqlFunction($function, array $params = array());

	/**
	 * @param $tableName
	 * @return \SlothMySql\Face\Value\TableInterface
	 */
	public function table($tableName);

	/**
	 * @param $tableName
	 * @param $fieldName
	 * @return \SlothMySql\Face\Value\Table\FieldInterface
	 */
	public function tableField($tableName, $fieldName);

	/**
	 * @return \SlothMySql\Face\Value\Table\DataInterface
	 */
	public function tableData();

	/**
	 * @param array $values
	 * @return \SlothMySql\Face\Value\ValueListInterface
	 */
	public function valueList(array $values);

	/**
	 * @param $value
	 * @return ValueInterface
	 */
	public function guess($value);

	/**
	 * @param $value
	 * @param $type
	 * @return ValueInterface
	 */
	public function createValue($value, $type);
}