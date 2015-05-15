<?php
namespace SlothMySql\QueryBuilder\Query;

use SlothMySql\QueryBuilder\Abstractory\MySqlQuery;
use SlothMySql\QueryBuilder\Value\Table\Data;
use SlothMySql\QueryBuilder\Value\Table;

class Insert extends MySqlQuery
{
	const INSERT = 'INSERT';
	const REPLACE = 'REPLACE';

	protected $insertType = self::INSERT;

	/**
	 * @var Table
	 */
	protected $table;

	/**
	 * @var Data
	 */
	protected $data;

	public function __toString()
	{
		$queryString = sprintf("%s INTO %s\n%s\nVALUES\n%s",
			$this->insertType, $this->table, $this->getFieldsString(), $this->getValuesString()
		);
		return $queryString;
	}

	protected function getFieldsString()
	{
		$fields = $this->data->getFields();
		foreach ($fields as $i => $field) {
			$theseFields = explode('.', (string)$field);
			$fields[$i] = array_pop($theseFields);
		}
		return sprintf("(%s)", implode(",", $fields));
	}

	protected function getValuesString()
	{
		$rows = $this->data->getRows();
		foreach ($rows as $i => $row) {
			foreach ($row as $j => $value) {
				$row[$j] = (string)$value;
			}
			$rows[$i] = sprintf("(%s)", implode(",", $row));
		}
		return implode(",\n", $rows);
	}

	/**
	 * Change this query to replace existing rows with the same primary key
	 * @return $this
	 */
	public function replaceRows()
	{
		$this->insertType = self::REPLACE;
		return $this;
	}

	/**
	 * @param Table $table
	 * @return Insert $this
	 */
	public function into(Table $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param Data $data
	 * @return Insert $this
	 */
	public function data(Data $data)
	{
		$this->data = $data;
		return $this;
	}
}
