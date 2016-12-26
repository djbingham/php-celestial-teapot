<?php
namespace PhpMySql\QueryBuilder\Factory;

use PhpMySql\Abstractory\AFactory;
use PhpMySql\Face\ValueFactoryInterface;
use PhpMySql\Face\ValueInterface;
use PhpMySql\QueryBuilder\Value\Text;
use PhpMySql\QueryBuilder\Value\Number;
use PhpMySql\QueryBuilder\Value\Constant;
use PhpMySql\QueryBuilder\Value\Table;
use PhpMySql\QueryBuilder\Value\ValueList;
use PhpMySql\QueryBuilder\Value\SqlFunction;

class Value extends AFactory implements ValueFactoryInterface
{
	/**
	 * @param string $string
	 * @return String
	 */
	public function string($string)
	{
		$value = new Text($this->connection);
		$value->setValue($string);
		return $value;
	}

	/**
	 * @param int|float $number
	 * @return Number
	 */
	public function number($number)
	{
		$value = new Number($this->connection);
		$value->setValue($number);
		return $value;
	}

	/**
	 * @param string $constant
	 * @return Constant
	 */
	public function sqlConstant($constant)
	{
		$value = new Constant($this->connection);
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
		$func = new SqlFunction($this->connection);
		$func->setFunction($function);
		$func->setParams($params);
		return $func;
	}

	/**
	 * @param string $tableName
	 * @return Table
	 */
	public function table($tableName)
	{
		$table = new Table($this->connection);
		$table->setTableName($tableName);
		return $table;
	}

	/**
	 * @param string $fieldName
	 * @return Table\Field
	 */
	public function field($fieldName)
	{
		$field = new Table\Field($this->connection);
		$field->setFieldName($fieldName);
		return $field;
	}

	/**
	 * @param string $tableName
	 * @param string $fieldName
	 * @return Table\Field
	 */
	public function tableField($tableName, $fieldName)
	{
		$table = new Table($this->connection);
		$table->setTableName($tableName);
		$field = $table->field($fieldName);
		return $field;
	}

	/**
	 * @return Table\Data
	 */
	public function tableData()
	{
		$data = new Table\Data($this->connection);
		return $data;
	}

	/**
	 * @param array $values
	 * @return ValueList
	 */
	public function valueList(array $values)
	{
		$valueList = new ValueList($this->connection);
		$valueList->setValues($values);
		return $valueList;
	}

	/**
	 * Guess the best type of value and return an instance of that
	 * @param mixed $value Value to turn into a value instance
	 * @return ValueInterface
	 */
	public function guess($value)
	{
		$type = $this->guessValueType($value);
		return $this->createValue($value, $type);
	}

	protected function guessValueType($value)
	{
		if ($value instanceof ValueInterface) {
			return 'literal';
		} elseif (is_null($value)) {
			return 'null';
		} elseif (is_array($value)) {
			return 'list';
		} elseif (is_numeric($value)) {
			return 'number';
		} elseif (is_bool($value)) {
			return 'boolean';
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
	 * Create a ValueInterface instance of give type, with given value
	 * @param mixed $value
	 * @param string $type
	 * @return ValueInterface
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
			case 'boolean':
				if ($value === true) {
					return $this->sqlConstant('TRUE');
				} else {
					return $this->sqlConstant('FALSE');
				}
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
