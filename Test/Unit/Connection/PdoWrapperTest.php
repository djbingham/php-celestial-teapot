<?php
namespace Test\Unit\Connection;

use Test\Abstractory\UnitTest;
use PhpMySql\Connection\PdoWrapper;

class PdoWrapperTest extends UnitTest
{
	/**
	 * @var \PDO
	 */
	private $mockPdoHandle;

	/**
	 * @var PdoWrapper
	 */
	private $object;

	public function setUp()
	{
		parent::setUp();
		$this->mockPdoHandle = $this->getMockBuilder('Test\Mock\PDO')->getMock();
		$this->object = new PdoWrapper($this->mockPdoHandle);
	}

	public function testExecuteQueryThrowsExceptionWithErrorDetailsIfQueryFails()
	{
		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();

		$this->mockPdoHandle->expects($this->once())
			->method('query')
			->willReturn(false);

		$this->mockPdoHandle->expects($this->once())
			->method('errorInfo')
			->willReturn(['001', 'ABC', 'SQL syntax error']);

		$this->setExpectedException('\Exception');
		$this->object->executeQuery($query);
	}

	public function testGetLastErrorWhenPdoReturnsError()
	{
		$query = $this->getMock('PhpMySql\Face\QueryInterface');
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('SCHMLEEARRRRGH!'));

		$expectedError = ['001', 'ABC', 'SQL syntax error'];

		$this->mockPdoHandle->expects($this->once())
			->method('query')
			->willReturn(false);

		$this->mockPdoHandle->expects($this->once())
			->method('errorInfo')
			->willReturn($expectedError);

		$this->setExpectedException('\Exception');
		try {
			$this->object->executeQuery($query);
		} catch (\Exception $e) {
			$this->assertSame($expectedError, $this->object->getLastError());
			throw $e;
		}
	}

	public function testGetLastErrorWhenPdoThrowsException()
	{
		$query = $this->getMock('PhpMySql\Face\QueryInterface');
		$query->expects($this->any())
			->method('__toString')
			->will($this->returnValue('SCHMLEEARRRRGH!'));

		$expectedError = ['001', 'ABC', 'SQL syntax error'];

		$this->mockPdoHandle->expects($this->once())
			->method('query')
			->willThrowException(new \PDOException('Some SQL error'));

		$this->mockPdoHandle->expects($this->once())
			->method('errorInfo')
			->willReturn($expectedError);

		$this->setExpectedException('\Exception');
		try {
			$this->object->executeQuery($query);
		} catch (\Exception $e) {
			$this->assertSame($expectedError, $this->object->getLastError());
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

		$queryString = 'SELECT * FROM guestbook';

		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->once())
			->method('__toString')
			->will($this->returnValue($queryString));

		$queryResult = $this->getMock('Test\Mock\PDOStatement');

		$queryResult->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn($data);

		$this->mockPdoHandle->expects($this->once())
			->method('query')
			->with($queryString)
			->willReturn($queryResult);

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertEquals($data, $this->object->getLastResultData());
	}

	public function testGetLastResultDataReturnsFalseWhenQueryHasNoResultSet()
	{
		$queryString = 'TRUNCATE guestbook';

		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->once())
			->method('__toString')
			->will($this->returnValue($queryString));

		$queryResult = $this->getMock('Test\Mock\PDOStatement');

		$queryResult->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$this->mockPdoHandle->expects($this->once())
			->method('query')
			->with($queryString)
			->willReturn($queryResult);

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(array(), $this->object->getLastResultData());
	}

	public function testGetLastInsertIdReturnsAutoIncrementValueFromLastInsertQuery()
	{
		$queryString = '
			INSERT INTO guestbook (`content`, `user`, `created`)
			VALUES("Testing insert ID", "Jack", "2010-04-28 17:45:07")
		';

		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->exactly(2))
			->method('__toString')
			->will($this->returnValue($queryString));

		$queryResult = $this->getMock('Test\Mock\PDOStatement');

		$queryResult->expects($this->exactly(2))
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$this->mockPdoHandle->expects($this->exactly(2))
			->method('query')
			->with($queryString)
			->willReturn($queryResult);

		$this->mockPdoHandle->expects($this->exactly(2))
			->method('lastInsertId')
			->will($this->onConsecutiveCalls('1', '2'));

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame(array(), $this->object->getLastResultData());
		$this->assertSame('1', $this->object->getLastInsertId());

		$this->assertSame($this->object, $this->object->executeQuery($query));
		$this->assertSame('2', $this->object->getLastInsertId());
	}

	public function testCountAffectedRows()
	{
		$queryStrings = [
			'
				INSERT INTO guestbook
 					(`content`, `user`, `created`)
				VALUES
					("Testing insert ID", "Jack", "2010-04-28 17:45:07")
			',
			'
				INSERT INTO guestbook
					(`content`, `user`, `created`)
				VALUES
					("Testing insert ID", "Jack", "2010-04-28 17:45:07"),
					("Testing insert ID", "Jill", "2010-04-28 21:32:15")
			'
		];

		$queries = [
			$this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock()
		];

		$queryResults = [
			$this->getMock('Test\Mock\PDOStatement'),
			$this->getMock('Test\Mock\PDOStatement')
		];

		$queries[0]->expects($this->once())
			->method('__toString')
			->willReturn($queryStrings[0]);

		$queries[1]->expects($this->once())
			->method('__toString')
			->willReturn($queryStrings[1]);

		$queryResults[0]->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$queryResults[1]->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$this->mockPdoHandle->expects($this->exactly(2))
			->method('query')
			->will($this->returnValueMap(
				[
					[$queryStrings[0], $queryResults[0]],
					[$queryStrings[1], $queryResults[1]]
				]
			));

		$this->assertSame($this->object, $this->object->executeQuery($queries[0]));

		$queryResults[0]->expects($this->once())
			->method('rowCount')
			->willReturn(1);

		$this->assertSame(1, $this->object->countAffectedRows());

		$this->assertSame($this->object, $this->object->executeQuery($queries[1]));

		$queryResults[1]->expects($this->once())
			->method('rowCount')
			->willReturn(2);

		$this->assertSame(2, $this->object->countAffectedRows());
	}

	public function testCountAffectedRowsReturnsZeroWhenLastQueryDidNotAffectRows()
	{
		$queryString = 'SELECT * FROM guestbook WHERE id = NULL';

		$query = $this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock();
		$query->expects($this->once())
			->method('__toString')
			->will($this->returnValue($queryString));

		$queryResult = $this->getMock('Test\Mock\PDOStatement');

		$queryResult->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$this->mockPdoHandle->expects($this->once())
			->method('query')
			->with($queryString)
			->willReturn($queryResult);

		$this->assertSame($this->object, $this->object->executeQuery($query));

		$queryResult->expects($this->once())
			->method('rowCount')
			->willReturn(0);

		$this->assertSame(0, $this->object->countAffectedRows());
	}

	public function testGetQueryLog()
	{
		$queryStrings = array(
			'SELECT * FROM guestbook',
			'SELECT * FROM guestbook WHERE DATE < NOW()'
		);

		$queries = array(
			$this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock(),
			$this->getMockBuilder('PhpMySql\Face\QueryInterface')->disableOriginalConstructor()->getMock()
		);

		$queryResults = [
			$this->getMock('Test\Mock\PDOStatement'),
			$this->getMock('Test\Mock\PDOStatement')
		];

		$queries[0]->expects($this->any())
			->method('__toString')
			->will($this->returnValue($queryStrings[0]));
		$queries[1]->expects($this->any())
			->method('__toString')
			->will($this->returnValue($queryStrings[1]));

		$queryResults[0]->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$queryResults[1]->expects($this->once())
			->method('fetchAll')
			->with(\PDO::FETCH_ASSOC)
			->willReturn(array());

		$this->mockPdoHandle->expects($this->exactly(2))
			->method('query')
			->will($this->returnValueMap(
				[
					[$queryStrings[0], $queryResults[0]],
					[$queryStrings[1], $queryResults[1]]
				]
			));

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
		$this->mockPdoHandle->expects($this->once())
			->method('beginTransaction');

		$output = $this->object->begin();
		$this->assertSame($this->object, $output);

		$log = $this->object->getQueryLog();
		$this->assertSame(array('BEGIN'), $log);
	}

	public function testCommit()
	{
		$this->object->begin();

		$this->mockPdoHandle->expects($this->once())
			->method('commit');

		$output = $this->object->commit();
		$this->assertSame($this->object, $output);

		$log = $this->object->getQueryLog();
		$this->assertSame(array('BEGIN', 'COMMIT'), $log);
	}

	public function testRollback()
	{
		$this->object->begin();

		$this->mockPdoHandle->expects($this->once())
			->method('rollback');

		$output = $this->object->rollback();
		$this->assertSame($this->object, $output);

		$log = $this->object->getQueryLog();
		$this->assertSame(array('BEGIN', 'ROLLBACK'), $log);
	}

	public function testEscapeString()
	{
		$string = 'This "string" will be escaped';
		$escapedString = 'This \"string\" will be escaped';

		$this->mockPdoHandle->expects($this->once())
			->method('quote')
			->with($string)
			->willReturn("'$escapedString'");

		$output = $this->object->escapeString($string);
		$this->assertSame($escapedString, $output);
	}
}