<?php
namespace SlothMySql\Abstractory;

interface IValueFactory
{
	/**
	 * @param $string
	 * @return AValue
	 */
	public function string($string);

	/**
	 * @param $number
	 * @return AValue
	 */
	public function number($number);

	/**
	 * @param $constant
	 * @return AValue
	 */
	public function sqlConstant($constant);

	/**
	 * @param $function
	 * @param array $params
	 * @return AValue
	 */
	public function sqlFunction($function, array $params = array());

	/**
	 * @param $tableName
	 * @return Value\ATable
	 */
	public function table($tableName);

	/**
	 * @param $tableName
	 * @param $fieldName
	 * @return Value\Table\AField
	 */
	public function tableField($tableName, $fieldName);

	/**
	 * @return AValue
	 */
	public function tableData();

	/**
	 * @param array $values
	 * @return AValueList
	 */
	public function valueList(array $values);

	/**
	 * @param $value
	 * @return AValue
	 */
	public function guess($value);

	/**
	 * @param $value
	 * @param $type
	 * @return AValue
	 */
	public function createValue($value, $type);
}