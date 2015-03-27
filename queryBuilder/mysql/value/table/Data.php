<?php
namespace PHPMySql\QueryBuilder\MySql\Value\Table;

use PHPMySql\DatabaseWrapper;
use PHPMySql\QueryBuilder\MySql\Abstractory\MySqlValue;

class Data
{
	/**
	 * @var DatabaseWrapper
	 */
	protected $databaseWrapper;
	protected $nullValue = null;
	protected $fields = array();
	protected $rows = array();

	protected $currentRowIndex = 0;
	protected $currentRowFields = array();
	protected $currentRowValues = array();

	public function setDatabaseWrapper(DatabaseWrapper $databaseWrapper)
	{
		$this->databaseWrapper = $databaseWrapper;
		return $this;
	}

	public function getDatabaseWrapper()
	{
		return $this->databaseWrapper;
	}

	public function setNullValue(MySqlValue $value)
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

	public function set(Field $field, MySqlValue $value)
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

	protected function indexOfCurrentRowField(Field $field)
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
		for ($i = 0; $i <= max(array_keys($this->currentRowValues)); $i++) {
			if (array_key_exists($i, $this->currentRowValues)) {
				$filledRow[] = $this->currentRowValues[$i];
			} else {
				$filledRow[] = $this->nullValue;
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
}