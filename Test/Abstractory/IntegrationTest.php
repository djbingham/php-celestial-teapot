<?php
namespace Test\Abstractory;

use PhpMySql\Connection\PdoWrapper;
use PhpMySql\DatabaseWrapper;
use PhpMySql\QueryBuilder;

abstract class IntegrationTest extends \PHPUnit_Extensions_Database_TestCase
{
	use Mocker;

	/**
	 * @var DatabaseWrapper
	 */
	protected $dbWrapper;

	/**
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * @var \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
	 */
	private $defaultDbConnection;

	public function setUp()
	{
		parent::setUp();

		$pdoWrapper = new PdoWrapper($this->getPdo());
		$queryBuilder = new QueryBuilder\Wrapper($pdoWrapper);

		$this->dbWrapper = new DatabaseWrapper($pdoWrapper, $queryBuilder);
	}

	protected function getConnection()
    {
    	if (!$this->defaultDbConnection) {
			$this->createTables();
			$this->defaultDbConnection = $this->createDefaultDBConnection($this->getPdo(), ':memory:');
		}
        return $this->defaultDbConnection;
    }

	protected function createTables()
	{
		$sql = file_get_contents(implode([dirname(__DIR__), 'Sample', 'Database', 'schema.ddl'], DIRECTORY_SEPARATOR));
		$result = $this->getPdo()->query($sql);
		if (!$result) {
			throw new \Exception('Failed to create tables for integration testing.');
		}
	}

    protected function getPdo()
	{
		if (!$this->pdo) {
			$this->pdo = new \PDO('sqlite::memory:');
		}
		return $this->pdo;
	}

    protected function createYamlDataSet($yamlFile)
	{
		return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet($yamlFile);
	}
}