<?php
namespace PHPMySql;

class Factory extends Abstractory\Factory
{
    public function wrapper()
	{
		$wrapper = $this->getCache('wrapper');
		if (is_null($wrapper)) {
			$wrapper = new DatabaseWrapper($this);
			$this->setCache('wrapper', $wrapper);
		}
		return $wrapper;
	}

	public function mySqli()
	{
		$mySqli = $this->getCache('mySqli');
		if (is_null($mySqli)) {
			$mySqli = new MySqli($this);
			$this->setCache('mySqli', $mySqli);

		}
		return $mySqli;
	}
}
