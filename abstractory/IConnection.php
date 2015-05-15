<?php
namespace SlothMySql\Abstractory;

interface IConnection
{
	public function begin();
	public function commit();
	public function rollback();
	public function executeQuery(AQuery $query);
	public function getLastResultData();
	public function getQueryLog();
	public function getLastInsertId();
	public function countAffectedRows();
	public function getLastError();
	public function escapeString($string);
}
