<?php
namespace Test\Abstractory;

use Test\Utility\MockBuilder;

trait Mocker
{
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