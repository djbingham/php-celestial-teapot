<?php

namespace PHPMySql\Test\QueryBuilder\MySql\Factory;

require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/bootstrap.php';

use PHPMySql\Test\Abstractory\UnitTest;
use PHPMySql\QueryBuilder\MySql\Query;
use PHPMySql\QueryBuilder\MySql\Factory\Join as JoinFactory;

class JoinTest extends UnitTest
{
	/**
	 * @var JoinFactory
	 */
	protected $object;

	public function setUp()
	{
		$this->object = new JoinFactory($this->mockBuilder()->connection());
	}

	public function testInner()
	{
		$output = $this->object->inner();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_INNER, $output->getType());
	}

	public function testOuter()
	{
		$output = $this->object->outer();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_OUTER, $output->getType());
	}

	public function testLeft()
	{
		$output = $this->object->left();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_LEFT, $output->getType());
	}

	public function testRight()
	{
		$output = $this->object->right();
		$this->assertInstanceOf('PHPMySql\QueryBuilder\MySql\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_RIGHT, $output->getType());
	}
}
