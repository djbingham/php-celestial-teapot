<?php

namespace PHPMySql\QueryBuilder\MySql\Factory;

use PHPMySql\DatabaseWrapper;
use PHPMySql\QueryBuilder\MySql;

class Value
{
	/**
	 * @var DatabaseWrapper
	 */
	protected $databaseWrapper;

	/**
	 * @param DatabaseWrapper $databaseWrapper
	 * @return $this
	 */
	public function setDatabaseWrapper(DatabaseWrapper $databaseWrapper)
	{
		$this->databaseWrapper = $databaseWrapper;
		return $this;
	}

	/**
	 * @return DatabaseWrapper
	 */
	public function getDatabaseWrapper()
	{
		return $this->databaseWrapper;
	}

	/**
	 * @param string $string
	 * @return MySql\Value\String
	 */
	public function string($string)
	{
		$value = new MySql\Value\String();
		$value->setDatabaseWrapper($this->getDatabaseWrapper());
		$value->setValue($string);
		return $value;
	}

	/**
	 * @param int|float $number
	 * @return MySql\Value\Number
	 */
	public function number($number)
	{
		$value = new MySql\Value\Number();
		$value->setDatabaseWrapper($this->getDatabaseWrapper());
		$value->setValue($number);
		return $value;
	}

	/**
	 * @param string $constant
	 * @return MySql\Value\Constant
	 */
	public function sqlConstant($constant)
	{
		$value = new MySql\Value\Constant();
		$value->setDatabaseWrapper($this->getDatabaseWrapper());
		$value->setValue($constant);
		return $value;
	}

	/**
	 * @param string $function
	 * @param array $params
	 * @return MySql\Value\SqlFunction
	 */
	public function sqlFunction($function, array $params = array())
	{
		$func = new MySql\Value\SqlFunction();
		$func->setDatabaseWrapper($this->getDatabaseWrapper());
		$func->setFunction($function);
		$func->setParams($params);
		return $func;
	}

	/**
	 * @param $tableName
	 * @return MySql\Value\Table
	 */
	public function table($tableName)
	{
		$table = new MySql\Value\Table();
		$table->setDatabaseWrapper($this->getDatabaseWrapper());
		$table->setTableName($tableName);
		return $table;
	}

	/**
	 * @param $tableName
	 * @param $fieldName
	 * @return MySql\Value\Table\Field
	 */
	public function tableField($tableName, $fieldName)
	{
		$table = new MySql\Value\Table();
		$table->setDatabaseWrapper($this->getDatabaseWrapper());
		$table->setTableName($tableName);
		$field = $table->field($fieldName);
		return $field;
	}

	/**
	 * @return MySql\Value\Table\Data
	 */
	public function tableData()
	{
		$data = new MySql\Value\Table\Data();
		$data->setDatabaseWrapper($this->getDatabaseWrapper());
		return $data;
	}

	/**
	 * @param array $values
	 * @return MySql\Value\ValueList
	 */
	public function valueList(array $values)
	{
		$valueList = new MySql\Value\ValueList($this->databaseWrapper);
		$valueList->setValues($values);
		return $valueList;
	}

	/**
	 * Guess the best type of MySqlValue and return an instance of that
	 * @param mixed $value Value to turn into a MySqlValue instance
	 * @return MySql\Abstractory\MySqlValue
	 */
	public function guess($value)
	{
		echo "\r\nGUESSING\r\n";
		$type = $this->guessValueType($value);
		return $this->createValue($value, $type);
	}

	protected function guessValueType($value)
	{
		if ($value instanceof MySql\Abstractory\MySqlValue) {
			return 'literal';
		} elseif (is_null($value)) {
			return 'null';
		} elseif (is_array($value)) {
			return 'list';
		} elseif (is_numeric($value)) {
			return 'number';
		} elseif (in_array($value, MySql\Value\Constant::$constants)) {
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
	 * @return MySql\Abstractory\MySqlValue
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
