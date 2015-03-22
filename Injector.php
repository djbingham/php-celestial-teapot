<?php
namespace PHPMySql;

class Injector
{
	/**
	 * @var Factory
	 */
	private $database;

    public function setFactories(array $factories)
	{
		if (array_key_exists('database', $factories)) {
			$this->database = $factories['database'];
		}
		return $this;
	}

	public function database()
	{
		if (is_null($this->database)) {
			$this->database = new Factory($this);
		}
		return $this->database;
	}
}
