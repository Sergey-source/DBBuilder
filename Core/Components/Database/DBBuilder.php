<?php
namespace Core\Components\Database;

use Core\Components\Database\DBDriver;

/**
 * Класс для работы с таблицами в базе данных
 */
class DBBuilder
{
	/**
	 *
	 * @var Core\Components\Database\DBDriver
	 */
	protected $dbDriver;

	public function __construct()
	{
		$this->dbDriver = new DBDriver();
	}

	/**
	 * Создаёт таблицу в базе данных
	 * @param  string $name имя таблицы
	 * @param  array  $fields поля в таблице
	 *
	 */
	public function create(string $name, array $fields)
	{
		$fields_sql = [];  // Хранит sql каждого поля таблицы
		$index_sql = [];  // Хранит sql установки индексов, если они существуют, для полей

		foreach ($fields as $field) {
			$fields_sql[] = $field->getSQL();

			if ($field->haveIndex()) {
				$index_sql[] = $field->getIndex();
			}
		}

		$sql = sprintf("CREATE TABLE %s (%s, %s)", $name, implode(', ', $fields_sql), implode(', ', $index_sql));
		
		$this->dbDriver->sql($sql);
	}

	/**
	 * Очищает таблицу
	 * @param  string $name
	 *
	 */
	public function drop($name)
	{
		$sql = 'DROP TABLE ' . $name;
		$this->dbDriver->sql($sql);
	}
}
