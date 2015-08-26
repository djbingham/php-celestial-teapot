<?php
namespace SlothMySql\Test\Unit\Database\Connector;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use SlothMySql\Test\Abstractory\UnitTest;
use SlothMySql\Connection\Database;

class ConnectionOptionsTest extends UnitTest
{
    /**
     * @var Database
     */
	protected $object;

	public function setUp()
	{
		$this->object = new Database(array());
	}

	public function testSetAndGetName()
	{
		$testData = 'dbName';
		$this->assertEquals($this->object, $this->object->setName($testData));
		$this->assertEquals($testData, $this->object->getName());
	}

	public function testSetAndGetHost()
	{
		$testData = 'hostName';
		$this->assertEquals($this->object, $this->object->setHost($testData));
		$this->assertEquals($testData, $this->object->getHost());
	}

	public function testSetAndGetPassword()
	{
		$testData = 'pwd';
		$this->assertEquals($this->object, $this->object->setPassword($testData));
		$this->assertEquals($testData, $this->object->getPassword());
	}

	public function testSetAndGetPort()
	{
		$testData = 1000;
		$this->assertEquals($this->object, $this->object->setPort($testData));
		$this->assertEquals($testData, $this->object->getPort());
	}

	public function testSetAndGetSocket()
	{
		$testData = 10;
		$this->assertEquals($this->object, $this->object->setSocket($testData));
		$this->assertEquals($testData, $this->object->getSocket());
	}

	public function testSetAndGetUsername()
	{
		$testData = 'user';
		$this->assertEquals($this->object, $this->object->setUsername($testData));
		$this->assertEquals($testData, $this->object->getUsername());
	}

	public function testConstructorSetsProperties()
	{
		$config = array(
			'host' => 'localhost',
			'username' => 'dbUser',
			'password' => 'dbPass',
			'name' => 'dbName',
			'port' => 81,
			'socket' => 2001
		);
		$database = new Database($config);
		$this->assertEquals($config['host'], $database->getHost());
		$this->assertEquals($config['username'], $database->getUsername());
		$this->assertEquals($config['password'], $database->getPassword());
		$this->assertEquals($config['name'], $database->getName());
		$this->assertEquals($config['port'], $database->getPort());
		$this->assertEquals($config['socket'], $database->getSocket());
	}

	public function testConstructorThrowsExceptionOnUnrecognisedConfigItem()
	{
		$this->setExpectedException('Exception', 'Unrecognised key in database config array: BadKey');
		new Database(array(
			'BadKey' => 'value'
		));
	}

	public function testValidateDatabaseNameRejectsEmptyValue()
	{
		$output = $this->object->validateDatabaseName('');
		$this->assertFalse($output);
	}

	public function testValidateDatabaseNameRejectsObject()
	{
		$output = $this->object->validateDatabaseName(new self);
		$this->assertFalse($output);
	}

	public function testValidateDatabaseNameRejectsArray()
	{
		$output = $this->object->validateDatabaseName(array());
		$this->assertFalse($output);
	}

	public function testValidateHostRejectsEmptyValue()
	{
		$output = $this->object->validateHost('');
		$this->assertFalse($output);
	}

	public function testValidateHostRejectsObject()
	{
		$output = $this->object->validateHost(new self);
		$this->assertFalse($output);
	}

	public function testValidateHostRejectsArray()
	{
		$output = $this->object->validateHost(array());
		$this->assertFalse($output);
	}

	public function testValidatePasswordRejectsObject()
	{
		$output = $this->object->validatePassword(new self);
		$this->assertFalse($output);
	}

	public function testValidatePasswordRejectsArray()
	{
		$output = $this->object->validatePassword(array());
		$this->assertFalse($output);
	}

	public function testValidatePortRejectsEmptyValue()
	{
		$output = $this->object->validatePort('');
		$this->assertFalse($output);
	}

	public function testValidatePortRejectsObject()
	{
		$output = $this->object->validatePort(new self);
		$this->assertFalse($output);
	}

	public function testValidatePortRejectsArray()
	{
		$output = $this->object->validatePort(array());
		$this->assertFalse($output);
	}

	public function testValidatePortRejectsFloat()
	{
		$output = $this->object->validatePort(7.2);
		$this->assertFalse($output);
	}

	public function testValidatePortRejectsTextString()
	{
		$output = $this->object->validatePort('someText');
		$this->assertFalse($output);
	}

	public function testValidateSocketRejectsEmptyValue()
	{
		$output = $this->object->validateSocket('');
		$this->assertFalse($output);
	}

	public function testValidateSocketRejectsObject()
	{
		$output = $this->object->validateSocket(new self);
		$this->assertFalse($output);
	}

	public function testValidateSocketRejectsArray()
	{
		$output = $this->object->validateSocket(array());
		$this->assertFalse($output);
	}

	public function testValidateSocketRejectsFloat()
	{
		$output = $this->object->validateSocket(7.2);
		$this->assertFalse($output);
	}

	public function testValidateSocketRejectsTextString()
	{
		$output = $this->object->validateSocket('someText');
		$this->assertFalse($output);
	}

	public function testValidateUsernameRejectsEmptyValue()
	{
		$output = $this->object->validateUsername('');
		$this->assertFalse($output);
	}

	public function testValidateUsernameRejectsObject()
	{
		$output = $this->object->validateUsername(new self);
		$this->assertFalse($output);
	}

	public function testValidateUsernameRejectsArray()
	{
		$output = $this->object->validateUsername(array());
		$this->assertFalse($output);
	}

	public function testValidate()
	{
		$this->object->setName('db');
		$this->object->setHost('hostname');
		$this->object->setPassword('pwd');
		$this->object->setPort(6000);
		$this->object->setSocket(1);
		$this->object->setUsername('uname');
		$this->assertTrue($this->object->validate());
		// Invalid database name
		$this->object->setName(array());
		$this->assertFalse($this->object->validate());
		$this->object->setName('db');
		// Invalid host
		$this->object->setHost(array());
		$this->assertFalse($this->object->validate());
		$this->object->setHost('hostname');
		// Invalid password
		$this->object->setPassword(array());
		$this->assertFalse($this->object->validate());
		$this->object->setPassword('pwd');
		// Invalid port
		$this->object->setPort(array());
		$this->assertFalse($this->object->validate());
		$this->object->setPort(6000);
		// Invalid socket
		$this->object->setSocket(array());
		$this->assertFalse($this->object->validate());
		$this->object->setSocket(1);
		// Invalid username
		$this->object->setUsername(array());
		$this->assertFalse($this->object->validate());
		$this->object->setUsername('uname');
		// Test still accepts valid object
		$this->assertTrue($this->object->validate());
	}

	public function testErrors()
	{
		$this->object->setName('db');
		$this->object->setHost('hostname');
		$this->object->setPassword('pwd');
		$this->object->setPort(6000);
		$this->object->setSocket(1);
		$this->object->setUsername('uname');
		$this->assertEmpty($this->object->errors());
		// Invalid database name
		$this->object->setName(array());
		$this->assertEquals(array(Database::ERROR_DATABASE_NAME), $this->object->errors());
		$this->object->setName('db');
		// Invalid host
		$this->object->setHost(array());
		$this->assertEquals(array(Database::ERROR_HOST), $this->object->errors());
		$this->object->setHost('hostname');
		// Invalid password
		$this->object->setPassword(array());
		$this->assertEquals(array(Database::ERROR_PASSWORD), $this->object->errors());
		$this->object->setPassword('pwd');
		// Invalid port
		$this->object->setPort(array());
		$this->assertEquals(array(Database::ERROR_PORT), $this->object->errors());
		$this->object->setPort(6000);
		// Invalid socket
		$this->object->setSocket(array());
		$this->assertEquals(array(Database::ERROR_SOCKET), $this->object->errors());
		$this->object->setSocket(1);
		// Invalid username
		$this->object->setUsername(array());
		$this->assertEquals(array(Database::ERROR_USERNAME), $this->object->errors());
		$this->object->setUsername('uname');
		// Test still accepts valid object
		$this->assertEmpty($this->object->errors());
	}
}
