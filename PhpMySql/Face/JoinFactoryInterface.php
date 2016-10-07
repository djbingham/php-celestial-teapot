<?php
namespace PhpMySql\Face;

use PhpMySql\Abstractory\Query;

interface JoinFactoryInterface
{
	/**
	 * @return \PhpMySql\Face\Query\JoinInterface
	 */
	public function outer();

	/**
	 * @return \PhpMySql\Face\Query\JoinInterface
	 */
	public function inner();

	/**
	 * @return \PhpMySql\Face\Query\JoinInterface
	 */
	public function left();

	/**
	 * @return \PhpMySql\Face\Query\JoinInterface
	 */
	public function right();
}