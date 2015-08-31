<?php
namespace SlothMySql\QueryBuilder\Value;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\ValueInterface;

class SqlFunction implements ValueInterface
{
	use QueryElementTrait;

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
			if (!$param instanceof ValueInterface) {
				throw new \Exception(
					sprintf('Invalid parameter value for SQL function: %s', print_r($param, true))
				);
			}
		}
		$this->params = $params;
		return $this;
	}
}