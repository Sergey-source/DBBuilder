<?php
namespace Core\Components\Migrations;

use Core\Components\Database\DBBuilder;
use Core\Components\Field\FieldDriver;

abstract class Migration
{
	/**
	 * 
	 * @var Core\Components\Database\DBBuilder
	 */
	protected $DBBuilder;

	/**
	 * 
	 * @var Core\Components\Field\FieldDriver
	 */
	protected $table;

	public function __construct()
	{
		$this->DBBuilder = new DBBuilder();
		$this->table = new FieldDriver();
	}

	/**
	 * Конфигурирует таблицу
	 *
	 */
	abstract function up();

	/**
	 * Очищает таблицу
	 *
	 */
	abstract function drop();
}
