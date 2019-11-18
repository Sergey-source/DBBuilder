<?php
namespace Core\Components\Database;

require_once dirname(dirname(dirname(__DIR__))) . '/settings/database.php';

/**
 * Класс для работы с базой данных
 */
class DBDriver
{
	/**
	 * 
	 * @var \PDO
	 */
	private $pdo;

	public function __construct()
	{
		$this->pdo = $this->getPDO();
	}

	/**
	 * Выполняет sql запрос
	 * 
	 */
	public function sql(string $sql)
	{
		$this->pdo->query($sql);
	}

	protected function getPDO()
	{
		$opt = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
		];

		$dsn = sprintf('mysql:host=%s;dbname=%s', DB['host'], DB['db_name']);

		return new \PDO($dsn, DB['login'], DB['password'], $opt);
	}
}
