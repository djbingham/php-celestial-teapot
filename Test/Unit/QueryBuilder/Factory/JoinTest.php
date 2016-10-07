<?php

namespace Test\QueryBuilder\Factory;

use Test\Abstractory\UnitTest;
use PhpMySql\QueryBuilder\Query;
use PhpMySql\QueryBuilder\Factory\Join as JoinFactory;

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
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_INNER, $output->getType());
	}

	public function testOuter()
	{
		$output = $this->object->outer();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_OUTER, $output->getType());
	}

	public function testLeft()
	{
		$output = $this->object->left();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_LEFT, $output->getType());
	}

	public function testRight()
	{
		$output = $this->object->right();
		$this->assertInstanceOf('PhpMySql\QueryBuilder\Query\Join', $output);
		$this->assertEquals(Query\Join::TYPE_RIGHT, $output->getType());
	}
}
