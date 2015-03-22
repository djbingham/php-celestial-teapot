<?php

namespace PHPMySql\Test;

class AutoLoader
{
	private $rootDirectory;
	private $namespacePrefix;

    public function __construct($rootDirectory, $namespacePrefix = null)
	{
		$this->rootDirectory = $rootDirectory;
		if (!is_null($namespacePrefix)) {
			$this->namespacePrefix = rtrim($namespacePrefix, '\\');
		}
		spl_autoload_register(array($this, 'load'));
	}

	public function load($className)
	{
		// Remove prefix from class name
		if (!is_null($this->namespacePrefix)) {
			$className = preg_replace(sprintf('/^%s\\\?/', $this->namespacePrefix), '', $className);
		}

		// Build directory path from namespace
		$namespaceParts = explode('\\', $className);
		$className = array_pop($namespaceParts);
		for ($i = 0; $i < count($namespaceParts); $i++) {
			$namespaceParts[$i] = lcfirst($namespaceParts[$i]);
		}
		$directory = implode(DIRECTORY_SEPARATOR, $namespaceParts);

		// Build file name and append onto the directory path
		$classFile = $this->concreteClassFile($className, $directory);

		if (!is_file($classFile)) {
			$classFile = $this->abstractClassFile($className, $directory);
		}

		if (!is_file($classFile)) {
			return false;
		}
		require $classFile;
		return true;
	}

	private function concreteClassFile($className, $namespaceDirectory)
	{
		$fileName = sprintf('%s.php', $className);
		$pathParts = array($this->rootDirectory, $namespaceDirectory, $fileName);
		return implode(DIRECTORY_SEPARATOR, $pathParts);
	}

	private function abstractClassFile($className, $namespaceDirectory)
	{
		$fileName = sprintf('%s.php', $className);
		$pathParts = array($this->rootDirectory, $namespaceDirectory, 'abstractory', $fileName);
		return implode(DIRECTORY_SEPARATOR, $pathParts);
	}
}
