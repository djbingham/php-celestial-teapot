<?php
namespace SlothMySql\Test\Utility\Mock;

use SlothMySql;

class DatabaseWrapper extends SlothMySql\DatabaseWrapper
{
    public function escapeString($string)
	{
		return $string;
	}
}
