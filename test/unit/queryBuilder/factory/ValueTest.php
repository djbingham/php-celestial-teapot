<?php

namespace SlothMySql\Test\Unit\Database\QueryBuilder\MySql\Factory;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\Test\Abstractory\UnitTest;
use SlothMySql\QueryBuilder\Value\String;
use SlothMySql\QueryBuilder\Value\ValueList;
use SlothMySql\QueryBuilder\Factory\Value as ValueFactory;

class ValueTest extends UnitTest
{
	/**
	 * @var ValueFactory
	 */
	protected $object;

	public function setup()
	{
		$connection = $this->mockBuilder()->connection();
		$this->object = new ValueFactory($connection);
	}

	protected function mockConnection($testValue, $escapedValue)
	{
		$wrapper = $this->mockBuilder()->connection();
		$wrapper->expects($this->any())
			->method('escapeString')
			->with($testValue)
			->will($this->returnValue($escapedValue));
		return $wrapper;
	}

	protected function getObject($connection)
	{
		return new ValueFactory($connection);
	}

	public function testString()
	{
		$testValue = 'String to be escaped';
		$escapedValue = 'Escaped string';
		$connection = $this->mockConnection($testValue, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->string($testValue);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\String', $output);
		$this->assertEquals('"'.$escapedValue.'"', (string) $output);
	}

	public function testNumber()
	{
		$testValue = 22;
		$escapedValue = 21;
		$connection = $this->mockConnection($testValue, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->number($testValue);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Number', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testSqlConstant()
	{
		$testValue = 'NULL';
		$escapedValue = 'NULL';
		$connection = $this->mockConnection($testValue, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->sqlConstant($testValue);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Constant', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testSqlFunction()
	{
		$testFunction = 'testFunc';
		$escapedFunction = 'escapedFunc';
		$testParams = array(
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock()
		);
		$testParams[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('1'));
		$testParams[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('2'));
		$connection = $this->mockConnection($testFunction, $escapedFunction);
		$object = $this->getObject($connection);

		$output = $object->sqlFunction($testFunction, $testParams);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\SqlFunction', $output);
		$this->assertEquals($escapedFunction.'('.implode(',', $testParams).')', (string) $output);
	}

	public function testTable()
	{
		$testValue = 'TableName';
		$escapedValue = 'EscapedTableName';
		$connection = $this->mockConnection($testValue, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->table($testValue);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table', $output);
		$this->assertEquals('`'.$escapedValue.'`', (string) $output);
	}

	public function testTableField()
	{
		$testTable = 'TableName';
		$escapedTable = 'EscapedTable';
		$testField = 'FieldName';
		$escapedField = 'EscapedField';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->returnValueMap(array(
				array($testTable, $escapedTable),
				array($testField, $escapedField)
			)));
		$object = $this->getObject($connection);
		$output = $object->tableField($testTable, $testField);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $output);
		$this->assertEquals('`'.$escapedTable.'`.`'.$escapedField.'`', (string) $output);
	}

	public function testTableData()
	{
		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$output = $object->tableData();
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Data', $output);
	}

	public function testValueList()
	{
		$testValues = array(
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock()
		);
		$testValues[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('1'));
		$testValues[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('2'));

		$wrapper = $this->mockBuilder()->databaseWrapper();
		$connection = $this->mockConnection($testValue, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->valueList($testValues);
		$this->assertTrue($output instanceof ValueList);
		$this->assertEquals('(1,2)', (string) $output);
	}

	public function testCreateValueLiteral()
	{
		$connection = $this->mockBuilder()->connection();
		$value = new String($connection);
		$object = $this->getObject($connection);
		$output = $object->createValue($value, 'literal');
		$this->assertEquals($value, $output);
	}

	public function testCreateValueList()
	{
		$list = array(
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock()
		);
		$list[0]->expects($this->once())
			->method('__toString')
			->will($this->returnValue('"value 1"'));
		$list[1]->expects($this->once())
			->method('__toString')
			->will($this->returnValue('"value 2"'));

		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$output = $object->createValue($list, 'list');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\ValueList', $output);
		$this->assertEquals('("value 1","value 2")', (string) $output);
	}

	public function testCreateValueNumber()
	{
		$value = '21';
		$escapedValue = '21';
		$connection = $this->mockConnection($value, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->createValue($value, 'number');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Number', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testCreateValueString()
	{
		$value = 'String value';
		$escapedValue = 'Escaped value';
		$connection = $this->mockConnection($value, $escapedValue);
		$object = $this->getObject($connection);
		$output = $object->createValue($value, 'string');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\String', $output);
		$this->assertEquals('"'.$escapedValue.'"', (string) $output);
	}

	public function testCreateValueConstant()
	{
		$value = 'NULL';
		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$output = $object->createValue($value, 'constant');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Constant', $output);
		$this->assertEquals($value, (string) $output);
	}

	public function testCreateValueFunction()
	{
		$value = 'funcName("param1", "param2")';
		$escapedValue = 'funcName("param1","param2")';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls('funcName', 'param1', 'param2'));
		$object = $this->getObject($connection);
		$output = $object->createValue($value, 'function');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\SqlFunction', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testCreateValueTableWithoutBackticks()
	{
		$value = 'TableName';
		$connection = $this->mockConnection($value, $value);
		$object = $this->getObject($connection);
		$output = $object->createValue($value, 'table');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table', $output);
		$this->assertEquals('`'.$value.'`', (string) $output);
	}

	public function testCreateValueTableWithBackticks()
	{
		$value = 'TableName';
		$connection = $this->mockConnection($value, $value);
		$object = $this->getObject($connection);
		$output = $object->createValue('`'.$value.'`', 'table');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table', $output);
		$this->assertEquals('`'.$value.'`', (string) $output);
	}

	public function testCreateValueTableFieldWithoutBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$object = $this->getObject($connection);
		$output = $object->createValue($table.'.'.$field, 'tableField');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueTableFieldWithBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$object = $this->getObject($connection);
		$output = $object->createValue('`'.$table.'`.`'.$field.'`', 'tableField');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueFieldWithoutBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$object = $this->getObject($connection);
		$output = $object->createValue($table.'.'.$field, 'field');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueFieldWithBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$object = $this->getObject($connection);
		$output = $object->createValue('`'.$table.'`.`'.$field.'`', 'field');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueInvalidType()
	{
		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$this->setExpectedException('\Exception');
		$object->createValue('value', 'Not a valid type');
	}

	public function testGuessLiteral()
	{
		$mockValue = $this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock();
		$mockValue->expects($this->any())
			->method('__toString')
			->will($this->returnValue('12'));

		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$output = $object->guess($mockValue);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Abstractory\MySqlValue', $output);
		$this->assertEquals($mockValue, $output);
	}

	public function testGuessNull()
	{
		$connection = $this->mockConnection(null, 'NULL');
		$object = $this->getObject($connection);
		$output = $object->guess(null);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Constant', $output);
		$this->assertEquals('NULL', (string) $output);
	}

	public function testGuessList()
	{
		$mockValues = array(
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('SlothMySql\QueryBuilder\Abstractory\MySqlValue')->disableOriginalConstructor()->getMock()
		);
		$mockValues[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('1'));
		$mockValues[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('2'));
		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$output = $object->guess($mockValues);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\ValueList', $output);
		$this->assertEquals('(1,2)', (string) $output);
	}

	public function testGuessNumber()
	{
		$connection = $this->mockConnection(22, '22');
		$object = $this->getObject($connection);
		$output = $object->guess(22);
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Number', $output);
		$this->assertEquals('22', (string) $output);
	}

	public function testGuessString()
	{
		$connection = $this->mockConnection('A string', 'Escaped string');
		$object = $this->getObject($connection);
		$output = $object->guess('A string');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\String', $output);
		$this->assertEquals('"Escaped string"', (string) $output);
	}

	public function testGuessConstant()
	{
		$connection = $this->mockBuilder()->connection();
		$object = $this->getObject($connection);
		$output = $object->guess('NULL');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Constant', $output);
		$this->assertEquals('NULL', (string) $output);
	}

	public function testGuessFunction()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls('funcName', 'param1', 'param2'));
		$object = $this->getObject($connection);
		$output = $object->guess('funcName("param1", "param2")');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\SqlFunction', $output);
		$this->assertEquals('funcName("param1","param2")', (string) $output);
	}

	public function testGuessTable()
	{
		$connection = $this->mockConnection('TableName', 'TableName');
		$object = $this->getObject($connection);
		$output = $object->guess('`TableName`');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table', $output);
		$this->assertEquals('`TableName`', (string) $output);
	}

	public function testGuessTableField()
	{
		$connection = $this->mockBuilder()->connection();
		$connection->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls('TableName', 'fieldName'));
		$object = $this->getObject($connection);
		$output = $object->guess('`TableName`.`fieldName`');
		$this->assertInstanceOf('SlothMySql\QueryBuilder\Value\Table\Field', $output);
		$this->assertEquals('`TableName`.`fieldName`', (string) $output);
	}
}
