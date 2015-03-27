<?php
namespace PHPMySql\Test\Mock;

class MySqli extends \MySqli
{
	/**
	 * @var array
	 */
	protected $expectedQuerySequence = array();

	/**
	 * @var array
	 */
	protected $expectedResponseSequence = array();

	/**
	 * @var array
	 */
	protected $expectedResultSequence = array();

	/**
	 * @var array
	 */
	protected $expectedPropertyUpdates = array();

	/**
	 * @var mixed Data to return on next call to store_result
	 */
	protected $expectedNextResult;

	/**
	 * @var array
	 */
	private $mockProperties = array();

	public function __get($name)
	{
		if (array_key_exists($name, $this->mockProperties)) {
			return $this->$name;
		}
	}

	/**
	 * @param string $query
	 * @return $this
	 * @throws \Exception if query doesn't match next expected query
	 */
	public function real_query($query)
	{
		$this->assertEqualsNextExpectedQuery((string) $query);
		array_shift($this->expectedQuerySequence);

		// If next response data is an exception, throw it
		if (count($this->expectedResultSequence) > 0) {
			$this->expectedNextResult = array_shift($this->expectedResultSequence);

			$expectedResponse = array_shift($this->expectedResponseSequence);
			if ($expectedResponse instanceof \Exception) {
				throw $expectedResponse;
			}

			if (count($this->expectedPropertyUpdates) > 0) {
				foreach (array_shift($this->expectedPropertyUpdates) as $property => $value) {
					$this->mockProperties[$property] = $value;
				}
			}
		} else {
			unset($this->expectedNextResult);
		}

		return $expectedResponse;
	}

	public function store_result()
	{
		$response = $this->expectedNextResult;
		if ($response instanceof \Exception) {
			throw $response;
		}
		return $response;
	}

	/**
	 * @param array $querySequence [[$queryString, $queryResult, $queryResponse]]
	 * @throws \Exception if any item in $querySequence has an invalid number of components
	 * @return $this
	 */
	public function expectQuerySequence(array $querySequence)
	{
		foreach ($querySequence as $index => $queryParams) {
			if (count($queryParams) !== 4) {
				throw new \Exception(
					sprintf(
						'Invalid parameter count given to Mock\MySqli::expectQuerySequence (item %s): %s',
						$index,
						print_r($queryParams, true)
					)
				);
			}
			$this->expectQuery($queryParams[0], $queryParams[1], $queryParams[2], $queryParams[3]);
		}
		return $this;
	}

	/**
	 * @param string $queryString
	 * @param * $response Response for the real_query call
	 * @param \MySqli_Result $result Response for the store_data call
	 * @param array $propertyValues Values to set for properties of this mock \MySqli object
	 * @return $this
	 */
	public function expectQuery($queryString, $response, $result, array $propertyValues)
	{
		$this->expectedQuerySequence[] = $queryString;
		$this->expectedResponseSequence[] = $response;
		$this->expectedResultSequence[] = $result;
		$this->expectedPropertyUpdates[] = $propertyValues;
		return $this;
	}

	private function assertEqualsNextExpectedQuery($actual)
	{
		$nextQuery = '';
		if (count($this->expectedQuerySequence) > 0) {
			$nextQuery = $this->expectedQuerySequence[0];
		}

		// Check that the query matches the next expected query string
		if ($nextQuery !== $actual) {
			$message = sprintf(
				"Failed asserting that query equals next expected query.\r\nActual: %s.\r\nExpected: %s",
				$actual,
				(string) $nextQuery
			);
			throw new \Exception($message);
		}
		return true;
	}
}