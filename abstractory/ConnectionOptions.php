<?php

namespace PHPMySql\Abstractory;

abstract class ConnectionOptions
{
	/**
	 * Validate the connector options, return whether the options are valid.
	 * @return Boolean Whether the options are valid.
	 */
	abstract public function validate();

	/**
	 * Validate the connector options, returning error messages.
	 * @return array List of error messages, if any validation errors were found.
	 */
	abstract public function errors();
}