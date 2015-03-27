<?php

namespace PHPMySql\Test\Unit\Database\QueryBuilder\MySql\Factory;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
use PHPMySql\QueryBuilder\MySql\Value\String;
use PHPMySql\QueryBuilder\MySql\Value\ValueList;
use PHPMySql\Factory\MySqli\QueryBuilder\Value as ValueFactory;

class ValueTest extends UnitTest
{
	/**
	 * @var ValueFactory
	 */
	protected $object;

	public function setup()
	{
		$databaseFactory = $this->mockBuilder()->factory();
		$this->object = new ValueFactory($databaseFactory);
	}

	protected function mockDatabaseWrapper($testValue, $escapedValue)
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->with($testValue)
			->will($this->returnValue($escapedValue));
		return $wrapper;
	}

	protected function mockDatabaseFactory($wrapper)
	{
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->any())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		return $databaseFactory;
	}

	protected function getObject($databaseFactory)
	{
		return new ValueFactory($databaseFactory);
	}

	public function testString()
	{
		$testValue = 'String to be escaped';
		$escapedValue = 'Escaped string';
		$wrapper = $this->mockDatabaseWrapper($testValue, $escapedValue);
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->string($testValue);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\String', $output);
		$this->assertEquals('"'.$escapedValue.'"', (string) $output);
	}

	public function testNumber()
	{
		$testValue = 22;
		$escapedValue = 21;
		$wrapper = $this->mockDatabaseWrapper($testValue, $escapedValue);
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->number($testValue);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Number', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testSqlConstant()
	{
		$testValue = 'NULL';
		$escapedValue = 'NULL';
		$wrapper = $this->mockDatabaseWrapper($testValue, $escapedValue);
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->sqlConstant($testValue);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Constant', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testSqlFunction()
	{
		$testFunction = 'testFunc';
		$escapedFunction = 'escapedFunc';
		$testParams = array(
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString')),
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString'))
		);
		$testParams[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('1'));
		$testParams[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('2'));
		$wrapper = $this->mockDatabaseWrapper($testFunction, $escapedFunction);
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);

		$output = $object->sqlFunction($testFunction, $testParams);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\SqlFunction', $output);
		$this->assertEquals($escapedFunction.'('.implode(',', $testParams).')', (string) $output);
	}

	public function testTable()
	{
		$testValue = 'TableName';
		$escapedValue = 'EscapedTableName';
		$wrapper = $this->mockDatabaseWrapper($testValue, $escapedValue);
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->table($testValue);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table', $output);
		$this->assertEquals('`'.$escapedValue.'`', (string) $output);
	}

	public function testTableField()
	{
		$testTable = 'TableName';
		$escapedTable = 'EscapedTable';
		$testField = 'FieldName';
		$escapedField = 'EscapedField';
		$dbWrapper = $this->mockBuilder()->databaseWrapper();
		$dbWrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($escapedTable, $escapedField));
		$databaseFactory = $this->mockDatabaseFactory($dbWrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->tableField($testTable, $testField);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $output);
		$this->assertEquals('`'.$escapedTable.'`.`'.$escapedField.'`', (string) $output);
	}

	public function testTableData()
	{
		$dbWrapper = $this->mockBuilder()->databaseWrapper();
		$databaseFactory = $this->mockDatabaseFactory($dbWrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->tableData();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Data', $output);
	}

	public function testValueList()
	{
		$testValues = array(
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString')),
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString'))
		);
		$testValues[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('1'));
		$testValues[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('2'));

		$wrapper = $this->mockBuilder()->databaseWrapper();
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->valueList($testValues);
		$this->assertTrue($output instanceof ValueList);
		$this->assertEquals('(1,2)', (string) $output);
	}

	public function testCreateValueLiteral()
	{
		$value = new String();
		$databaseFactory = $this->mockDatabaseFactory($this->mockBuilder()->databaseWrapper());
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($value, 'literal');
		$this->assertEquals($value, $output);
	}

	public function testCreateValueList()
	{
		$list = array(
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString')),
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString'))
		);
		$list[0]->expects($this->once())
			->method('__toString')
			->will($this->returnValue('"value 1"'));
		$list[1]->expects($this->once())
			->method('__toString')
			->will($this->returnValue('"value 2"'));

		$databaseFactory = $this->mockDatabaseFactory($this->mockBuilder()->databaseWrapper());
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($list, 'list');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\ValueList', $output);
		$this->assertEquals('("value 1","value 2")', (string) $output);
	}

	public function testCreateValueNumber()
	{
		$value = '21';
		$escapedValue = '21';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($value)
			->will($this->returnValue($escapedValue));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($value, 'number');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Number', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testCreateValueString()
	{
		$value = 'String value';
		$escapedValue = 'Escaped value';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($value)
			->will($this->returnValue($escapedValue));
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($value, 'string');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\String', $output);
		$this->assertEquals('"'.$escapedValue.'"', (string) $output);
	}

	public function testCreateValueConstant()
	{
		$value = 'NULL';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($value, 'constant');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Constant', $output);
		$this->assertEquals($value, (string) $output);
	}

	public function testCreateValueFunction()
	{
		$value = 'funcName("param1", "param2")';
		$escapedValue = 'funcName("param1","param2")';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls('funcName', 'param1', 'param2'));
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($value, 'function');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\SqlFunction', $output);
		$this->assertEquals($escapedValue, (string) $output);
	}

	public function testCreateValueTableWithoutBackticks()
	{
		$value = 'TableName';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($value)
			->will($this->returnValue($value));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($value, 'table');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table', $output);
		$this->assertEquals('`'.$value.'`', (string) $output);
	}

	public function testCreateValueTableWithBackticks()
	{
		$value = 'TableName';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with($value)
			->will($this->returnValue($value));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue('`'.$value.'`', 'table');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table', $output);
		$this->assertEquals('`'.$value.'`', (string) $output);
	}

	public function testCreateValueTableFieldWithoutBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($table.'.'.$field, 'tableField');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueTableFieldWithBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue('`'.$table.'`.`'.$field.'`', 'tableField');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueFieldWithoutBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue($table.'.'.$field, 'field');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueFieldWithBackTicks()
	{
		$table = 'TableName';
		$field = 'FieldName';
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls($table, $field));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->createValue('`'.$table.'`.`'.$field.'`', 'field');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $output);
		$this->assertEquals('`'.$table.'`.`'.$field.'`', (string) $output);
	}

	public function testCreateValueInvalidType()
	{
		$databaseFactory = $this->mockDatabaseFactory($this->mockBuilder()->databaseWrapper());
		$object = $this->getObject($databaseFactory);
		$this->setExpectedException('\Exception');
		$object->createValue('value', 'Not a valid type');
	}

	public function testGuessLiteral()
	{
		$mockValue = $this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString'));
		$mockValue->expects($this->any())
			->method('__toString')
			->will($this->returnValue('12'));

		$databaseFactory = $this->mockDatabaseFactory($this->mockBuilder()->databaseWrapper());
		$object = $this->getObject($databaseFactory);
		$output = $object->guess($mockValue);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', $output);
		$this->assertEquals($mockValue, $output);
	}

	public function testGuessNull()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->guess(null);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Constant', $output);
		$this->assertEquals('NULL', (string) $output);
	}

	public function testGuessList()
	{
		$mockValues = array(
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString')),
			$this->getMock('PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue', array('__toString'))
		);
		$mockValues[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('1'));
		$mockValues[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue('2'));
		$databaseFactory = $this->mockDatabaseFactory($this->mockBuilder()->databaseWrapper());
		$object = $this->getObject($databaseFactory);
		$output = $object->guess($mockValues);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\ValueList', $output);
		$this->assertEquals('(1,2)', (string) $output);
	}

	public function testGuessNumber()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with(22)
			->will($this->returnValue('22'));
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->guess(22);
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Number', $output);
		$this->assertEquals('22', (string) $output);
	}

	public function testGuessString()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with('A string')
			->will($this->returnValue('Escaped string'));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->guess('A string');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\String', $output);
		$this->assertEquals('"Escaped string"', (string) $output);
	}

	public function testGuessConstant()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->guess('NULL');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Constant', $output);
		$this->assertEquals('NULL', (string) $output);
	}

	public function testGuessFunction()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls('funcName', 'param1', 'param2'));
		$databaseFactory = $this->mockDatabaseFactory($wrapper);
		$object = $this->getObject($databaseFactory);
		$output = $object->guess('funcName("param1", "param2")');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\SqlFunction', $output);
		$this->assertEquals('funcName("param1","param2")', (string) $output);
	}

	public function testGuessTable()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->once())
			->method('escapeString')
			->with('TableName')
			->will($this->returnValue('TableName'));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->guess('`TableName`');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table', $output);
		$this->assertEquals('`TableName`', (string) $output);
	}

	public function testGuessTableField()
	{
		$wrapper = $this->mockBuilder()->databaseWrapper();
		$wrapper->expects($this->any())
			->method('escapeString')
			->will($this->onConsecutiveCalls('TableName', 'fieldName'));
		$databaseFactory = $this->mockBuilder()->factory();
		$databaseFactory->expects($this->once())
			->method('wrapper')
			->will($this->returnValue($wrapper));
		$object = $this->getObject($databaseFactory);
		$output = $object->guess('`TableName`.`fieldName`');
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Value\Table\Field', $output);
		$this->assertEquals('`TableName`.`fieldName`', (string) $output);
	}
}
