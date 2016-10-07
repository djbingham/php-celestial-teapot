<?php
namespace PhpMySql\Connection;

class Database
{
	const ERROR_DATABASE_NAME = 'Invalid database name';
	const ERROR_HOST = 'Invalid host';
	const ERROR_PASSWORD = 'Invalid password';
	const ERROR_PORT = 'Invalid port';
	const ERROR_SOCKET = 'Invalid socket';
	const ERROR_USERNAME = 'Invalid username';

	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $host;
	/**
	 * @var string
	 */
	protected $password;
	/**
	 * @var int
	 */
	protected $port;
	/**
	 * @var int
	 */
	protected $socket;
	/**
	 * @var string
	 */
	protected $username;

	public function __construct(array $config)
	{
		foreach ($config as $key => $value) {
			$setter = 'set' . ucfirst($key);
			if (method_exists($this, $setter)) {
				$this->$setter($value);
			} else {
				throw new \Exception(sprintf('Unrecognised key in database config array: %s', $key));
			}
		}
	}

	/**
	 * @param string $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $host
	 * @return $this
	 */
	public function setHost($host)
	{
		$this->host = $host;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * @param string $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param int $port
	 * @return $this
	 */
	public function setPort($port)
	{
		$this->port = $port;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * @param int $socket
	 * @return $this
	 */
	public function setSocket($socket)
	{
		$this->socket = $socket;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getSocket()
	{
		return $this->socket;
	}

	/**
	 * @param string $username
	 * @return $this
	 */
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	public function validate()
	{
		$valid = true;
		$valid = $valid && $this->validateDatabaseName($this->name);
		$valid = $valid && $this->validateHost($this->host);
		$valid = $valid && $this->validatePassword($this->password);
		$valid = $valid && $this->validatePort($this->port);
		$valid = $valid && $this->validateSocket($this->socket);
		$valid = $valid && $this->validateUsername($this->username);
		return $valid;
	}

	public function errors()
	{
		$errors = array();
		if (!$this->validateDatabaseName($this->name)) {
			$errors[] = self::ERROR_DATABASE_NAME;
		}
		if (!$this->validateHost($this->host)) {
			$errors[] = self::ERROR_HOST;
		}
		if (!$this->validatePassword($this->password)) {
			$errors[] = self::ERROR_PASSWORD;
		}
		if (!$this->validatePort($this->port)) {
			$errors[] = self::ERROR_PORT;
		}
		if (!$this->validateSocket($this->socket)) {
			$errors[] = self::ERROR_SOCKET;
		}
		if (!$this->validateUsername($this->username)) {
			$errors[] = self::ERROR_USERNAME;
		}
		return $errors;
	}

	/**
	 * @param string $name
	 * @return Boolean
	 */
	public function validateDatabaseName($name)
	{
		return (!empty($name) && is_string($name));
	}

	/**
	 * @param string $host
	 * @return Boolean
	 */
	public function validateHost($host)
	{
		return (!empty($host) && is_string($host));
	}

	/**
	 * @param int $socket
	 * @return Boolean
	 */
	public function validateSocket($socket)
	{
		return (is_null($socket) || is_integer($socket));
	}

	/**
	 * @param string $username
	 * @return Boolean
	 */
	public function validateUsername($username)
	{
		return (!empty($username) && is_string($username));
	}

	/**
	 * @param string $password
	 * @return Boolean
	 */
	public function validatePassword($password)
	{
		return (is_null($password) || is_string($password));
	}

	/**
	 * @param int $port
	 * @return Boolean
	 */
	public function validatePort($port)
	{
		return (is_null($port) || is_integer($port));
	}
}