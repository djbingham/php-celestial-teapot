<?php
namespace PhpMySql\Face\Value\Table;

use PhpMySql\Face\ValueInterface;
use PhpMySql\Face\Value\TableInterface;

interface FieldInterface extends ValueInterface
{
	/**
	 * @param TableInterface $table
	 * @return $this
	 */
	public function setTable(TableInterface $table);

	/**
	 * @param string $fieldName
	 * @return $this
	 */
	public function setFieldName($fieldName);

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias($alias);

	/**
	 * @return string
	 */
	public function getAlias();
}