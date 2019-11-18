<?php
namespace Core\Components\Migrations;

use Core\Components\Migrations\Migration;
use Core\Components\Filesystem\Filesystem;

/**
 * Генерирует список миграций
 */
class Migrator
{
	/**
	 * 
	 * @var Core\Components\Filesystem\Filesystem
	 */
	private $filesystem;

	/**
	 * Путь к директории с миграциями
	 * @var string
	 */
	private $migrations_path;

	public function __construct()
	{
		$this->filesystem = new Filesystem();
		$this->migrations_path = dirname(dirname(dirname(__DIR__))) . '/Migrations/';
	}

	/**
	 * Отдаёт список всех объектов-миграций
	 * @return array
	 */
	public function getAllMigrations()
	{
		$files = $this->getAllMigrationsFiles();
		$migrations = [];

		foreach ($files as $file) {
			$class_name = $this->getMigrationClassName($file);
			
			$this->requireMigration($class_name);
			
			$migrations[] = new $class_name();
		}

		return $migrations;
	}

	/**
	 * Отдаёт список объектов-миграций
	 * @param  array  $migrations_name список имён миграций, которые надо выпонить
	 * @return array
	 */
	public function getMigrations(array $migrations_name)
	{
		$migrations = [];
		
		foreach ($migrations_name as $class_name) {
			$this->requireMigration($class_name);

			$migrations[] = new $class_name();
		}

		return $migrations;
	}

	private function getMigrationClassName($file)
	{
		$migration_name = str_replace('.php', '', $file);
		return $migration_name;
	}

	private function getAllMigrationsFiles()
	{
		$files = $this->filesystem->scanDir($this->migrations_path);
		return $files;
	}

	/**
	 * Загружает миграцию
	 * @param  string $class_name
	 *
	 */
	private function requireMigration($class_name)
	{
		$path = $this->migrations_path . $class_name . '.php';
		require_once $path;
	}
}
