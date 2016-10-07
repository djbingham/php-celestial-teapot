<?php
namespace Test\QueryBuilder\Query;

use PhpMySql\QueryBuilder\Query\Insert;
use Test\Abstractory\UnitTest;

class InsertTest extends UnitTest
{
	/**
	 * @var Insert
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Insert($this->mockBuilder()->connection());
	}

	protected function mockTable($tableName)
	{
		$table = $this->mockBuilder()->queryValue('Table');
		$table->expects($this->any())
			->method('__toString')
			->will($this->returnValue($tableName));
		return $table;
	}

	protected function mockData(array $fields, array $values)
	{
		$data = $this->mockBuilder()->queryValue('Table\\Data');
		$data->expects($this->any())
			->method('getFields')
			->will($this->returnValue($fields));
		$data->expects($this->any())
			->method('getRows')
			->will($this->returnValue($values));
		return $data;
	}

	public function testIntoReturnsInsertInstance()
	{
		$table = $this->mockTable('`TableName`');
		$output = $this->object->into($table);
		$this->assertEquals($this->object, $output);
	}

	public function testGetTableReturnsTableInstance()
	{
		$table = $this->mockTable('`TableName`');
		$this->object->into($table);
		$this->assertSame($table, $this->object->getTable());
	}

	public function testDataReturnsInsertInstance()
	{
		$data = $this->mockData(array('`TableName`.`field1`'), array(array('"value1"')));
		$output = $this->object->data($data);
		$this->assertEquals($this->object, $output);
	}

	public function testGetDataReturnsDataInstance()
	{
		$data = $this->mockData(array('`TableName`.`field1`'), array(array('"value1"')));
		$this->object->data($data);
		$this->assertSame($data, $this->object->getData());
	}

	public function testisReplaceQueryReturnsFalseByDefault()
	{
		$this->assertFalse($this->object->isReplaceQuery());
	}

	public function testReplaceRowsMakesIsReplaceQueryTrue()
	{
		$this->assertSame($this->object, $this->object->replaceRows());
		$this->assertTrue($this->object->isReplaceQuery());
	}

	public function testToString()
	{
		$table = $this->mockTable('`TableName`');
		$fields = array('`TableName`.`field1`', '`TableName`.`field2`', '`TableName`.`field3`');
		$values = array(
			array('"value11"', '"value12"', 'NULL'),
			array('"value21"', 'NULL', '"value23"')
		);
		$mockData = $this->mockData($fields, $values);
		$this->object->into($table)
			->data($mockData);
		$expectedString = <<<EOT
INSERT INTO `TableName`
(`field1`,`field2`,`field3`)
VALUES
("value11","value12",NULL),
("value21",NULL,"value23")
EOT;
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Insert', $this->object);
		$this->assertEquals($expectedString, (string)$this->object);
	}

	public function testReplaceRowsChangesQueryToReplace()
	{
		$table = $this->mockTable('`TableName`');
		$fields = array('`TableName`.`field1`', '`TableName`.`field2`', '`TableName`.`field3`');
		$values = array(
			array('"value11"', '"value12"', 'NULL'),
			array('"value21"', 'NULL', '"value23"')
		);
		$mockData = $this->mockData($fields, $values);
		$this->object->into($table)
			->data($mockData)
			->replaceRows();
		$expectedString = <<<EOT
REPLACE INTO `TableName`
(`field1`,`field2`,`field3`)
VALUES
("value11","value12",NULL),
("value21",NULL,"value23")
EOT;
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Insert', $this->object);
		$this->assertEquals($expectedString, (string)$this->object);
	}
}
