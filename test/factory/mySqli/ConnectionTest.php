<?php

namespace PHPMySql\Test\Factory\MySqli;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use PHPMySql\Test\UnitTest;
use PHPMySql\Factory\MySqli\Connection as ConnectionFactory;

class ConnectionTest extends UnitTest
{
	/**
	 * @var ConnectionFactory
	 */
	protected $object;
	protected $databaseName = 'dbName';

	public function setUp()
	{
		$database = $this->mockBuilder()->factory();
		$this->object = new ConnectionFactory($database);
	}

    public function testSetAndGetByName()
	{
		$names = array(
			'Connection 1',
			'Connection 2'
		);
		$options = array(
			$this->mockBuilder()->connectionOptions(),
			$this->mockBuilder()->connectionOptions()
		);
		$options[0]->expects($this->once())
			->method('getDatabaseName')
			->will($this->returnValue('conn1'));
		$options[1]->expects($this->once())
			->method('getDatabaseName')
			->will($this->returnValue('conn2'));

		// Test creating a new connection
		$this->assertEquals($this->object, $this->object->set($names[0], $options[0]));

		// Test fetching the connection by name
		$connection1 = $this->object->get($names[0]);
		$this->assertInstanceOf('PHPMySql\Connector\Connection\MySqli', $connection1);
		$this->assertEquals($options[0], $connection1->getOptions());

		// Create a second connection
		$this->assertEquals($this->object, $this->object->set($names[1], $options[1]));

		// Fetch each connection by name
		$connection1 = $this->object->get($names[0]);
		$connection2 = $this->object->get($names[1]);
		$this->assertInstanceOf('PHPMySql\Connector\Connection\MySqli', $connection1);
		$this->assertEquals($options[0], $connection1->getOptions());
		$this->assertEquals('conn1', $connection1->getOptions()->getDatabaseName());
		$this->assertEquals('conn2', $connection2->getOptions()->getDatabaseName());
		$this->assertInstanceOf('PHPMySql\Connector\Connection\MySqli', $connection2);
		$this->assertEquals($options[1], $connection2->getOptions());

	}

	public function testGetThrowsExceptionIfNoConnectionExistsWithGivenName()
	{
		// No connections exist
		$this->setExpectedException('\Exception', 'MySqli connector does not exist: Connection Name');
		$this->object->get('Connection Name');
		// Create a connection, then give no options for a different name
	}
}
