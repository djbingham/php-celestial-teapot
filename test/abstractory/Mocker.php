<?php
namespace PHPMySql\Test\Abstractory;

use PHPMySql\Test\Utility\Mock;
use PHPMySql\Test\Utility\MockBuilder;

trait Mocker
{
	/**
	 * @var Mock
	 */
	private $sample;

	/**
	 * @var MockBuilder
	 */
	private $mockBuilder;

	/**
	 * @return MockBuilder
	 */
	public function mockBuilder()
	{
		if (is_null($this->mockBuilder)) {
			$this->mockBuilder = new MockBuilder();
		}
		return $this->mockBuilder;
	}

	/**
	 * @return Mock
	 */
	public function mock()
	{
		if (!isset($this->sample)) {
			$this->sample = new Mock();
		}
		return $this->sample;
	}

	/**
	 * @return string
	 */
	public function rootDir()
	{
		return dirname(__DIR__);
	}

	/**
	 * @return string
	 */
	public function tmpDir()
	{
		$directory = implode(DIRECTORY_SEPARATOR, array($this->rootDir(), 'tmp'));
		if (!file_exists($directory)) {
			mkdir($directory);
		}
		return $directory;
	}
}