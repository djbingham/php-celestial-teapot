<?php
namespace SlothMySql\QueryBuilder\Query;

use SlothMySql\Base\QueryElementTrait;
use SlothMySql\Face\Query\InsertInterface;
use SlothMySql\Face\Value\Table\DataInterface;
use SlothMySql\Face\Value\TableInterface;

class Insert implements InsertInterface
{
	use QueryElementTrait;

	protected $insertType = self::INSERT;

	/**
	 * @var TableInterface
	 */
	protected $table;

	/**
	 * @var DataInterface
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
	 * Check whether this query is set to replace rows
	 * @return boolean
	 */
	public function isReplaceQuery()
	{
		return $this->insertType === self::REPLACE;
	}

	/**
	 * @param TableInterface $table
	 * @return InsertInterface $this
	 */
	public function into(TableInterface $table)
	{
		$this->table = $table;
		return $this;
	}

	/**
	 * @param DataInterface $data
	 * @return InsertInterface $this
	 */
	public function data(DataInterface $data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @return DataInterface
	 */
	public function getData()
	{
		return $this->data;
	}
}
