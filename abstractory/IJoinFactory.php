<?php
namespace PHPMySql\Abstractory;

interface IJoinFactory
{
	/**
	 * @return Query\AJoin
	 */
	public function outer();

	/**
	 * @return Query\AJoin
	 */
	public function inner();

	/**
	 * @return Query\AJoin
	 */
	public function left();

	/**
	 * @return Query\AJoin
	 */
	public function right();
}