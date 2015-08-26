<?php

namespace SlothMySql\QueryBuilder\Factory;

use SlothMySql\Abstractory\AFactory;
use SlothMySql\Abstractory\IJoinFactory;

class Join extends AFactory implements IJoinFactory
{
	public function inner()
	{
		$join = new \SlothMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\SlothMySql\QueryBuilder\Query\Join::TYPE_INNER);
	}

	public function outer()
	{
		$join = new \SlothMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\SlothMySql\QueryBuilder\Query\Join::TYPE_OUTER);
	}

	public function left()
	{
		$join = new \SlothMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\SlothMySql\QueryBuilder\Query\Join::TYPE_LEFT);
	}

	public function right()
	{
		$join = new \SlothMySql\QueryBuilder\Query\Join($this->connection);
		return $join->setType(\SlothMySql\QueryBuilder\Query\Join::TYPE_RIGHT);
	}
}
