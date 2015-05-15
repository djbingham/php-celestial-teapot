<?php
namespace SlothMySql\Test\QueryBuilder\Query;

require_once dirname(dirname(dirname(__DIR__))) . '/bootstrap.php';

use SlothMySql\QueryBuilder\Query\Delete;
use SlothMySql\Test\Abstractory\UnitTest;

class DeleteTest extends UnitTest
{
	/**
	 * @var Delete
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Delete($this->mockBuilder()->connection());
	}

	protected function mockTable($tableName)
	{
		$table = $this->mockBuilder()->queryValue('Table');
		$table->expects($this->any())
			->method('__toString')
			->will($this->returnValue($tableName));
		return $table;
	}

	protected function mockConstraint($string)
	{
		$constraint = $this->getMockBuilder('SlothMySql\QueryBuilder\Query\Constraint')
			->disableOriginalConstructor()
			->getMock();
		$constraint->expects($this->any())
			->method('__toString')
			->will($this->returnValue($string));
		return $constraint;
	}

	public function testFromAcceptsTableAndReturnsDeleteInstance()
	{
		$output = $this->object->from($this->mockTable('`TableName`'));
		$this->assertEquals($this->object, $output);
	}

	public function testWhereAcceptsConstraintAndReturnsDeleteInstance()
	{
		$output = $this->object->where($this->mockConstraint('constraint string'));
		$this->assertEquals($this->object, $output);
	}

	public function testToStringReturnsCorrectSqlQuery()
	{
		$this->object->from($this->mockTable('`TableName`'))
			->where($this->mockConstraint('constraint string'));
		$expected = <<<EOT
DELETE FROM `TableName`
WHERE constraint string
EOT;
		$this->assertEquals($expected, (string)$this->object);
	}

	public function testToStringWithoutConditionOmitsWhereClauseFromSqlQuery()
	{
		$this->object->from($this->mockTable('`TableName`'));
		$expected = "DELETE FROM `TableName`";
		$this->assertEquals($expected, (string)$this->object);
	}
}
