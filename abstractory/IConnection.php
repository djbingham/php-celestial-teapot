<?php
namespace PHPMySql\Abstractory;

interface IConnection
{
	public function begin();
	public function commit();
	public function rollback();
	public function executeQuery(Query $query);
	public function getLastResultData();
	public function getQueryLog();
	public function getLastInsertId();
	public function countAffectedRows();
	public function getLastError();
	public function escapeString($string);
}