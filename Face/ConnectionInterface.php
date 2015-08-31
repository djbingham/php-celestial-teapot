<?php
namespace SlothMySql\Face;

interface ConnectionInterface
{
	public function begin($flags = null, $name = null);
	public function commit($flags = null, $name = null);
	public function rollback($flags = null, $name = null);
	public function executeQuery(QueryInterface $query);
	public function getLastResultData();
	public function getQueryLog();
	public function getLastInsertId();
	public function countAffectedRows();
	public function getLastError();
	public function escapeString($string);
}
