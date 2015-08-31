<?php
namespace SlothMySql\Test\QueryBuilder\Query;

use SlothMySql\Test\Abstractory\UnitTest;
use SlothMySql\QueryBuilder\Query\Update;

class UpdateTest extends UnitTest
{
	/**
	 * @var Update
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Update($this->mockBuilder()->connection());
	}

	protected function mockTable($tableName)
	{
		$table = $this->mockBuilder()->queryValue('Table');
		$table->expects($this->any())
			->method('__toString')
			->will($this->returnValue($tableName));
		return $table;
	}

	protected function mockField($fieldName)
	{
		$field = $this->getMockBuilder('SlothMySql\Face\Value\Table\FieldInterface')
			->disableOriginalConstructor()
			->getMock();
		$field->expects($this->any())
			->method('__toString')
			->will($this->returnValue($fieldName));
		return $field;
	}

	protected function mockValue($string)
	{
		$value = $this->getMockBuilder('SlothMySql\Face\ValueInterface')
			->disableOriginalConstructor()
			->getMock();
		$value->expects($this->any())
			->method('__toString')
			->will($this->returnValue($string));
		return $value;
	}

	protected function mockData(array $fields, array $values)
	{
		$data = $this->getMockBuilder('SlothMySql\Face\Value\Table\DataInterface')
			->disableOriginalConstructor()
			->getMock();
		$data->expects($this->any())
			->method('getFields')
			->will($this->returnValue($fields));
		$data->expects($this->any())
			->method('getRows')
			->will($this->returnValue($values));
		return $data;
	}

	protected function mockConstraint($string)
	{
		$constraint = $this->getMockBuilder('SlothMySql\Face\Query\ConstraintInterface')
			->disableOriginalConstructor()
			->getMock();
		$constraint->expects($this->any())
			->method('__toString')
			->will($this->returnValue($string));
		return $constraint;
	}

	public function testTableAcceptsTableAndReturnsUpdateInstance()
	{
		$output = $this->object->table($this->mockTable('`TableName`'));
		$this->assertEquals($this->object, $output);
	}

	public function testSetAndGetFieldsAndGetValues()
	{
		$fields = array(
			$this->mockField('`TableName`.`Field1`'),
			$this->mockField('`TableName`.`Field2`')
		);
		$values = array(
			$this->mockValue('value 1'),
			$this->mockValue('value 2')
		);
		$this->assertEquals($this->object, $this->object->set($fields[0], $values[0]));
		$this->assertEquals(array_slice($fields, 0, 1), $this->object->getFields());
		$this->assertEquals(array_slice($values, 0, 1), $this->object->getValues());
		$this->assertEquals($this->object, $this->object->set($fields[1], $values[1]));
		$this->assertEquals($fields, $this->object->getFields());
		$this->assertEquals($values, $this->object->getValues());
	}

	public function testSetWithExistingField()
	{
		$fields = array(
			$this->mockField('`TableName`.`Field1`'),
			$this->mockField('`TableName`.`Field2`')
		);
		$values = array(
			$this->mockValue('value 1'),
			$this->mockValue('value 2'),
			$this->mockValue('value 3'),
			$this->mockValue('value 4')
		);
		$this->assertEquals($this->object, $this->object->set($fields[0], $values[0]));
		$this->assertEquals($this->object, $this->object->set($fields[1], $values[1]));
		$this->assertEquals($fields, $this->object->getFields());
		$this->assertEquals(array_slice($values, 0, 2), $this->object->getValues());
		// Change one value
		$this->assertEquals($this->object, $this->object->set($fields[0], $values[2]));
		$this->assertEquals($fields, $this->object->getFields());
		$this->assertEquals(array($values[2], $values[1]), $this->object->getValues());
		// Change the other value
		$this->assertEquals($this->object, $this->object->set($fields[1], $values[3]));
		$this->assertEquals($fields, $this->object->getFields());
		$this->assertEquals(array_slice($values, 2, 2), $this->object->getValues());
	}

	public function testDataAcceptsDataInstanceAndReturnsUpdateInstance()
	{
		$fields = array($this->mockField('`TableName`.`FieldName`'));
		$values = array(array($this->mockValue('"value string"')));
		$output = $this->object->data($this->mockData($fields, $values));
		$this->assertEquals($this->object, $output);
	}

	public function testWhereAcceptsConstraintInstanceAndReturnsUpdateInstance()
	{
		$output = $this->object->where($this->mockConstraint('constraint string'));
		$this->assertEquals($this->object, $output);
	}

	public function testToStringReturnsCorrectSqlQuery()
	{
		$this->object->table($this->mockTable('`TableName`'))
			->set($this->mockField('`TableName`.`field1`'), $this->mockValue('"value 1"'))
			->set($this->mockField('`TableName`.`field2`'), $this->mockValue('"value 2"'))
			->where($this->mockConstraint('constraint string'));
		$expectedSql = <<<EOT
UPDATE `TableName`
SET `TableName`.`field1` = "value 1",
	`TableName`.`field2` = "value 2"
WHERE constraint string
EOT;
		$this->assertEquals($expectedSql, (string)$this->object);
	}
}
