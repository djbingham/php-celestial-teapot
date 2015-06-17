<?php
namespace SlothMySql\Test\QueryBuilder\Value\Table;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use SlothMySql\QueryBuilder\Value\Table\Field;
use SlothMySql\Test\Abstractory\UnitTest;

class FieldTest extends UnitTest
{
	/**
	 * @var Field
	 */
	protected $object;

	public function setup()
	{
		$this->object = new Field($this->mock()->connection());
	}

    public function testWithTableAndField()
    {
        $this->assertEquals($this->object, $this->object->setTable($this->mockTable('testTable')));
        $this->assertEquals($this->object, $this->object->setFieldName('testField'));
        $this->assertEquals('`testTable`.`testField`', (string)$this->object);
    }

    public function testWithTableFieldAndAlias()
    {
        $this->assertEquals($this->object, $this->object->setTable($this->mockTable('testTable')));
        $this->assertEquals($this->object, $this->object->setFieldName('testField'));
        $this->assertEquals($this->object, $this->object->setAlias('testAlias'));
        $this->assertEquals('`testTable`.`testField` AS `testAlias`', (string)$this->object);

    }

    public function testWithFieldOnly()
    {
        $this->assertEquals($this->object, $this->object->setFieldName('testField'));
        $this->assertEquals('`testField`', (string)$this->object);
    }

    public function testWithFieldAndAlias()
    {
        $this->assertEquals($this->object, $this->object->setFieldName('testField'));
        $this->assertEquals($this->object, $this->object->setAlias('testAlias'));
        $this->assertEquals('`testField` AS `testAlias`', (string)$this->object);
    }

    private function mockTable($tableName)
    {
        $table = $this->mockBuilder()->queryValue('table');
        $table->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue(sprintf('`%s`', $tableName)));
        return $table;
    }
}
