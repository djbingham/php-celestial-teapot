<?php
namespace PHPMySql\QueryBuilder\Value;

use PHPMySql\QueryBuilder\Abstractory\MySqlValue;

class SqlFunction extends MySqlValue
{
	protected $function;
	protected $params;

	public function __toString()
	{
		return sprintf('%s(%s)', $this->escapeString($this->function), implode(',', $this->params));
	}

	/**
	 * @param string $function
	 * @return SqlFunction $this
	 */
	public function setFunction($function)
	{
		$this->function = $function;
		return $this;
	}

	/**
	 * @param array $params
	 * @return SqlFunction $this
	 * @throws \Exception
	 */
	public function setParams(array $params)
	{
		// Make sure only valid values are passed in as params
		foreach ($params as $param) {
			if (!$param instanceof MySqlValue) {
				throw new \Exception('Invalid parameter value');
			}
		}
		$this->params = $params;
		return $this;
	}
}