<?php
namespace SlothMySql\Face;

interface QueryElementInterface
{
	/**
	 * @return string
	 */
	public function __toString();

	/**
	 * @param ConnectionInterface $connection
	 */
	public function __construct(ConnectionInterface $connection);

	/**
	 * @return ConnectionInterface
	 */
	public function getConnection();

	/**
	 * @param string $string
	 * @return string
	 */
	public function escapeString($string);
}