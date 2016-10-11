<?php
namespace PhpMySql\Face;

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
	 * @return \PhpMySql\Face\Value\TableInterface
	 */
	public function table($tableName);

	/**
	 * @param $fieldName
	 * @return \PhpMySql\Face\Value\Table\FieldInterface
	 */
	public function field($fieldName);

	/**
	 * @param $tableName
	 * @param $fieldName
	 * @return \PhpMySql\Face\Value\Table\FieldInterface
	 */
	public function tableField($tableName, $fieldName);

	/**
	 * @return \PhpMySql\Face\Value\Table\DataInterface
	 */
	public function tableData();

	/**
	 * @param array $values
	 * @return \PhpMySql\Face\Value\ValueListInterface
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