<?php

namespace PHPMySql\Factory\MySqli\QueryBuilder;

use PHPMySql\Factory\SubFactory;
use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue;
use PHPMySql\QueryBuilder\MySql\Value\String;
use PHPMySql\QueryBuilder\MySql\Value\Number;
use PHPMySql\QueryBuilder\MySql\Value\Constant;
use PHPMySql\QueryBuilder\MySql\Value\Table;
use PHPMySql\QueryBuilder\MySql\Value\ValueList;
use PHPMySql\QueryBuilder\MySql\Value\SqlFunction;

class Value extends SubFactory
{
	/**
	 * @param string $string
	 * @return String
	 */
	public function string($string)
	{
		$value = new String();
		$value->setDatabaseWrapper($this->database->wrapper());
		$value->setValue($string);
		return $value;
	}

	/**
	 * @param int|float $number
	 * @return Number
	 */
	public function number($number)
	{
		$value = new Number();
		$value->setDatabaseWrapper($this->database->wrapper());
		$value->setValue($number);
		return $value;
	}

	/**
	 * @param string $constant
	 * @return Constant
	 */
	public function sqlConstant($constant)
	{
		$value = new Constant();
		$value->setDatabaseWrapper($this->database->wrapper());
		$value->setValue($constant);
		return $value;
	}

	/**
	 * @param string $function
	 * @param array $params
	 * @return SqlFunction
	 */
	public function sqlFunction($function, array $params = array())
	{
		$func = new SqlFunction();
		$func->setDatabaseWrapper($this->database->wrapper());
		$func->setFunction($function);
		$func->setParams($params);
		return $func;
	}

	/**
	 * @param $tableName
	 * @return Table
	 */
	public function table($tableName)
	{
		$table = new Table();
		$table->setDatabaseWrapper($this->database->wrapper());
		$table->setTableName($tableName);
		return $table;
	}

	/**
	 * @param $tableName
	 * @param $fieldName
	 * @return Table\Field
	 */
	public function tableField($tableName, $fieldName)
	{
		$table = new Table();
		$table->setDatabaseWrapper($this->database->wrapper());
		$table->setTableName($tableName);
		$field = $table->field($fieldName);
		return $field;
	}

	/**
	 * @return Table\Data
	 */
	public function tableData()
	{
		$data = new Table\Data();
		$data->setDatabaseWrapper($this->database->wrapper());
		return $data;
	}

	/**
	 * @param array $values
	 * @return ValueList
	 */
	public function valueList(array $values)
	{
		$valueList = new ValueList($this->database->wrapper());
		$valueList->setValues($values);
		return $valueList;
	}

	/**
	 * Guess the best type of MySqlValue and return an instance of that
	 * @param mixed $value Value to turn into a MySqlValue instance
	 * @return MySqlValue
	 */
	public function guess($value)
	{
		$type = $this->guessValueType($value);
		return $this->createValue($value, $type);
	}

	protected function guessValueType($value)
	{
		if ($value instanceof MySqlValue) {
			return 'literal';
		} elseif (is_null($value)) {
			return 'null';
		} elseif (is_array($value)) {
			return 'list';
		} elseif (is_numeric($value)) {
			return 'number';
		} elseif (in_array($value, Constant::$constants)) {
			return 'constant';
		} elseif (preg_match('/^.+\(.+\)$/', (string)$value)) {
			return 'function';
		} elseif (preg_match('/^`.+`\.`.+`$/', (string)$value)) {
			return 'tableField';
		} elseif (preg_match('/^`[^`]+`$/', (string)$value)) {
			return 'table';
		} else {
			return 'string';
		}
	}

	/**
	 * Create a MySqlValue instance of give type, with given value
	 * @param mixed $value
	 * @param string $type
	 * @return MySqlValue
	 * @throws \Exception
	 */
	public function createValue($value, $type)
	{
		switch ($type) {
			case 'literal':
				return $value;
				break;
			case 'null':
				return $this->sqlConstant('NULL');
				break;
			case 'list':
				return $this->valueList($value);
				break;
			case 'number':
				return $this->number($value);
				break;
			case 'string':
				return $this->string($value);
				break;
			case 'constant':
				return $this->sqlConstant($value);
				break;
			case 'function':
				list($function, $args) = explode('::SEPARATOR::', preg_replace('/^(.+)\((.+)\)$/', '$1::SEPARATOR::$2', $value));
				$args = explode(',', $args);
				foreach ($args as $i => $arg) {
					$args[$i] = $this->guess(trim($arg));
				}
				return $this->sqlFunction(trim($function), $args);
				break;
			case 'table':
				return $this->table(trim($value, '`'));
				break;
			case 'tableField':
			case 'field':
				list($table, $field) = explode('.', $value);
				return $this->tableField(trim($table, '`'), trim($field, '`'));
				break;
			default:
				throw new \Exception('Invalid value type given to MySql::createValueInstance');
				break;
		}
	}
}
