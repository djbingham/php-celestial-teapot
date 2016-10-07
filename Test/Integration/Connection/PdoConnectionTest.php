<?php
namespace Test\Integration\Connection;

use Test\Abstractory\DatabaseTest;
use PhpMySql\Connection\PdoWrapper;

class PdoConnectionTest extends DatabaseTest
{
	/**
	 * @var \PDO
	 */
	private $pdoHandle;

	/**
	 * @var PdoWrapper
	 */
	private $object;

	public function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . DIRECTORY_SEPARATOR . 'MySqliTestFixture.xml');
	}

	public function setUp()
	{
		parent::setUp();
		$this->pdoHandle = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);
		$this->object = new PdoWrapper($this->pdoHandle);
	}

	protected function prepareTables()
	{
		$this->executeDbQuery('DROP TABLE IF EXISTS `guestbook`')
			->executeDbQuery('
				CREATE TABLE `guestbook` (
					`id` INT(10) AUTO_INCREMENT PRIMARY KEY,
					`content` VARCHAR(100),
					`user` VARCHAR(100),
					`created` DATETIME
				)
				ENGINE = MEMORY
				');
	}

	public function testExecuteQueryWithThrowsExceptionIfQueryFails()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('SCHMLEEARRRRGH!'));

		$this->setExpectedException('\Exception');
		$this->object->executeQuery($query);
	}

	public function testGetLastError()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('SCHMLEEARRRRGH!'));

		$this->setExpectedException('\Exception');
		try {
			$this->object->executeQuery($query);
		} catch (\Exception $e) {
			$this->assertSame($this->pdoHandle->errorInfo(), $this->object->getLastError());
			throw $e;
		}
	}

	public function testExecuteQueryAndGetLastResultDataReturnsSelectedData()
	{
		$data = array(
			array(
				'id' => 1,
				'content' => 'Hello buddy!',
				'user' => 'joe',
				'created' => '2010-04-24 17:15:23'
			),
			array(
				'id' => 2,
				'content' => 'I like it!',
				'user' => null,
				'created' => '2010-04-26 12:14:20'
			)
		);

		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('SELECT * FROM guestbook'));

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertEquals($data, $this->object->getLastResultData());
	}

	public function testGetLastResultDataReturnsFalseWhenQueryHasNoResultSet()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();

		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('TRUNCATE guestbook'));

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(array(), $this->object->getLastResultData());
	}

	public function testGetLastInsertIdReturnsAutoIncrementValueFromLastInsertQuery()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('
				INSERT INTO guestbook (`content`, `user`, `created`)
				VALUES("Testing insert ID", "Jack", "2010-04-28 17:45:07")
				'));

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(array(), $this->object->getLastResultData());
		$this->assertSame('3', $this->object->getLastInsertId());

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame('4', $this->object->getLastInsertId());
	}

	public function testCountAffectedRows()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('
				INSERT INTO guestbook
					(`content`, `user`, `created`)
				VALUES
					("Testing insert ID", "Jack", "2010-04-28 17:45:07")
				'));
		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(1, $this->object->countAffectedRows());

		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('
				INSERT INTO guestbook
					(`content`, `user`, `created`)
				VALUES
					("Testing insert ID", "Jack", "2010-04-28 17:45:07"),
					("Testing insert ID", "Jack", "2010-04-28 17:45:07")
				'));
		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(2, $this->object->countAffectedRows());
	}

	public function testCountAffectedRowsReturnsZeroWhenLastQueryDidNotAffectRows()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('
				SELECT * FROM guestbook
				WHERE id = NULL
				'));
		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(0, $this->object->countAffectedRows());
	}

	public function testGetQueryLog()
	{
		$queries = array(
			$this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock()
		);

		$queryStrings = array(
			'SELECT * FROM guestbook',
			'SELECT * FROM guestbook'
		);

		$queries[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue($queryStrings[0]));
		$queries[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue($queryStrings[1]));

		// Test log is initially empty
		$this->assertSame(array(), $this->object->getQueryLog());

		// Test first query enters log
	$this->object->executeQuery($queries[0]);
		$this->assertSame(array($queryStrings[0]), $this->object->getQueryLog());

		// Test second query is appended to log
	$this->object->executeQuery($queries[1]);
		$this->assertSame($queryStrings, $this->object->getQueryLog());
	}

	public function testBegin()
	{
		$output = $this->object->begin();
		$this->assertSame($this->object, $output);
		$log = $this->object->getQueryLog();
		$this->assertSame(array('BEGIN'), $log);
	}

	public function testCommit()
	{
		$this->object->begin();
		$output = $this->object->commit();
		$this->assertSame($this->object, $output);
		$log = $this->object->getQueryLog();
		$this->assertSame(array('BEGIN', 'COMMIT'), $log);
	}

	public function testRollback()
	{
		$this->object->begin();
		$output = $this->object->rollback();
		$this->assertSame($this->object, $output);
		$log = $this->object->getQueryLog();
		$this->assertSame(array('BEGIN', 'ROLLBACK'), $log);
	}

	public function testEscapeString()
	{
		$string = 'This "string" will be escaped';
		$escapedString = 'This \"string\" will be escaped';
		$output = $this->object->escapeString($string);
		$this->assertSame($escapedString, $output);
	}
}