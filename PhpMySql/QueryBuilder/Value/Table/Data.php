<?php
namespace PhpMySql\QueryBuilder\Value\Table;

use PhpMySql\Face\ConnectionInterface;
use PhpMySql\Face\Value\Table\DataInterface;
use PhpMySql\Face\Value\Table\FieldInterface;
use PhpMySql\Face\ValueInterface;

class Data implements DataInterface
{
	/**
	 * @var ConnectionInterface
	 */
	protected $connection;
	protected $nullValue = null;
	protected $fields = array();
	protected $rows = array();

	protected $currentRowIndex = 0;
	protected $currentRowFields = array();
	protected $currentRowValues = array();

	public function setConnection(ConnectionInterface $connection)
	{
		$this->connection = $connection;
		return $this;
	}

	public function getConnection()
	{
		return $this->connection;
	}

	public function setNullValue(ValueInterface $value)
	{
		$this->nullValue = $value;
		return $this;
	}

	public function getNullValue()
	{
		return $this->nullValue;
	}

	public function beginRow($index = null)
	{
		if (!is_null($index) && !is_integer($index)) {
			$errorMsg = sprintf('Non-integer index (%s) given to %s::beginRow is invalid', $index, get_class($this));
			throw new \Exception($errorMsg);
		}

		if (is_null($index)) {
			$index = count($this->rows);
			$this->currentRowValues = array();
		} elseif (!array_key_exists($index, $this->rows)) {
			$this->currentRowValues = array();
		} else {
			$this->currentRowValues = $this->rows[$index];
		}
		$this->currentRowFields = $this->fields;
		$this->currentRowIndex = $index;
		return $this;
	}

	public function getCurrentRowIndex()
	{
		return $this->currentRowIndex;
	}

	public function set(FieldInterface $field, ValueInterface $value)
	{
		$columnIndex = $this->indexOfCurrentRowField($field);
		$this->currentRowFields[$columnIndex] = $field;
		$this->currentRowValues[$columnIndex] = $value;
		return $this;
	}

	public function getCurrentRow()
	{
		return array_combine($this->currentRowFields, $this->currentRowValues);
	}

	protected function indexOfCurrentRowField(FieldInterface $field)
	{
		foreach ($this->currentRowFields as $index => $currentField) {
			if ((string)$field == (string)$currentField) {
				return $index;
			}
		}
		return count($this->currentRowFields);
	}

	public function endRow()
	{
		$this->fillCurrentRow();
		$this->saveCurrentRow();
		$this->clearCurrentRow();
		return $this;
	}

	protected function fillCurrentRow()
	{
		$filledRow = array();
		if (count($this->currentRowValues) > 0) {
			for ($i = 0; $i <= max(array_keys($this->currentRowValues)); $i++) {
				if (array_key_exists($i, $this->currentRowValues)) {
					$filledRow[] = $this->currentRowValues[$i];
				} else {
					$filledRow[] = $this->nullValue;
				}
			}
		}
		$this->currentRowValues = $filledRow;
	}

	protected function saveCurrentRow()
	{
		$this->fields = $this->currentRowFields;
		$this->rows[$this->currentRowIndex] = $this->currentRowValues;
	}

	protected function clearCurrentRow()
	{
		$this->currentRowFields = array();
		$this->currentRowValues = array();
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getRows()
	{
		$numColumns = count($this->fields);
		$allValues = array();
		foreach ($this->rows as $rowValues) {
			$rowValues = array_pad($rowValues, $numColumns, $this->nullValue);
			$allValues[] = array_combine($this->fields, $rowValues);
		}
		return $allValues;
	}

	public function numRows()
	{
		return count($this->rows);
	}
}
