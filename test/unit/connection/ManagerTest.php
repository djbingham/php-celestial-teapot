<?php
namespace PHPMySql\Test\Factory;

require_once dirname(dirname(__DIR__)) . '/bootstrap.php';

use PHPMySql\Connection\Manager as ConnectionManager;
use PHPMySql\Test\Abstractory\UnitTest;

class ManagerTest extends UnitTest
{
	/**
	 * @var ConnectionManager
	 */
	private $object;

	public function setUp()
	{
		$this->object = new ConnectionManager();
	}

	public function testSetAndGet()
	{
		$names = array('MyFirstDatabase', 'MySecondDatabase');
		$databases = array(
			$this->getMockBuilder('PHPMySql\Connection\MySqli')
				->disableOriginalConstructor()
				->getMock(),
			$this->getMockBuilder('PHPMySql\Connection\MySqli')
				->disableOriginalConstructor()
				->getMock()
		);
		$this->assertEquals($this->object, $this->object->set($names[0], $databases[0]));
		$this->assertEquals($this->object, $this->object->set($names[1], $databases[1]));
		$this->assertEquals($databases[0], $this->object->get($names[0]));
		$this->assertEquals($databases[1], $this->object->get($names[1]));
	}

	public function testGetThrowsExceptionIfNoDatabaseSet()
	{
		$this->setExpectedException('Exception', 'No database connection found with name: NoDatabase');
		$this->object->get('NoDatabase');
	}
}
