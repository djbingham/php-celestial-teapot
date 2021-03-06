<?php
namespace PhpMySql\QueryBuilder\Value;

use PhpMySql\Base\QueryElementTrait;
use PhpMySql\Face\ValueInterface;

class SqlFunction implements ValueInterface
{
	use QueryElementTrait;

	public static $functions = ['AVG', 'COUNT', 'MAX', 'MIN', 'SUM'];

	protected $function;
	protected $params = [];

	public function __toString()
	{
		return sprintf('%s(%s)', $this->function, implode(',', $this->params));
	}

	/**
	 * @param string $function
	 * @return SqlFunction $this
	 * @throws \Exception
	 */
	public function setFunction($function)
	{
		if (!is_string($function)) {
            throw new \Exception('Invalid type specified for name of SQL function. Must be a string.');
        }

        $function = strtoupper($function);

		if (!in_array($function, self::$functions)) {
			throw new \Exception(
				sprintf('Invalid name specified for SQL function. Must be one of: %s.', implode(', ', self::$functions))
			);
		}

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
				if (is_array($param) || is_object($param)) {
					$paramString = json_encode($param);
				} else {
					$paramString = (string) $param;
				}
				throw new \Exception(
					sprintf('Invalid parameter value for SQL function: %s', $paramString)
				);
			}
		}

		$this->params = $params;

		return $this;
	}
}