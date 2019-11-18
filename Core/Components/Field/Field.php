<?php
namespace Core\Components\Field;

/**
 * Класс для генерирования поля для базы данных
 */
class Field
{
	/**
	 * Имя поля
	 * @var string
	 */
	protected $name;

	/**
	 * Тип поля
	 * @var string
	 */
	protected $type;

	/**
	 * Длина поля
	 * @var int
	 */
	protected $length;

	/**
	 * Параметры поля
	 * @var array
	 */
	protected $attrs = [];

	/**
	 * Индекс поля, если он объявлен
	 * @var string
	 */
	protected $index = '';

	public function __construct(string $name, $length, string $type)
	{
		$this->name = $name;
		$this->type = $type;
		$this->length = $length;
		$this->attrs[] = 'NOT NULL'; // Значение по умолчанию
	}

	/**
	 * Устанавливает NULL для поля
	 * @return Core\Components\Field\Field
	 */
	public function nullable()
	{
		$this->attrs[] = 'NULL';
		return $this;
	}

	/**
	 * Устанавливает значение по умолчанию
	 * 
	 * @return Core\Components\Field\Field
	 */
	public function default(string $value)
	{
		$this->attrs[] = sprintf("DEFAULT '%s'", $value);
		return $this;
	}

	/**
	 * Добавляет autoIncrement для поля
	 * @return Core\Components\Field\Field
	 */
	public function autoIncrement()
	{
		$this->attrs[] = 'AUTO_INCREMENT';
		return $this;
	}

	/**
	 * Устанавливает INDEX для поля
	 * @return Core\Components\Field\Field
	 */
	public function index()
	{
		$this->index = 'INDEX';
		return $this;
	}

	/**
	 * Устанавливает UNIQUE для поля
	 * @return Core\Components\Field\Field
	 */
	public function unique()
	{
		$this->index = 'UNIQUE';
		return $this;
	}

	/**
	 * Устанавливает PRIMARY KEY для поля
	 * @return Core\Components\Field\Field
	 */
	public function primaryKey()
	{
		$this->index = 'PRIMARY	KEY';
		return $this;
	}

	/**
	 * Устанавливает FULLTEXT для поля
	 * @return Core\Components\Field\Field
	 */
	public function fullText()
	{
		$this->index = 'FULLTEXT';
		return $this;
	}

	/**
	 * Устанавливает SPATIAL для поля
	 * @return Core\Components\Field\Field
	 */
	public function spatial()
	{
		$this->index = 'SPATIAL';
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getSQL()
	{
		return $this->genSQL();
	}

	/**
	 * 
	 * @return string
	 */
	public function getIndex()
	{
		if ($this->index) {
			return sprintf('%s(%s)', $this->index, $this->name);
		}
	}

	/**
	 * Проверяет есть ли у поля индекс
	 * @return boolean
	 */
	public function haveIndex()
	{
		return ($this->index) ? true : false;
	}

	/**
	 * Генерирует sql
	 * @return string
	 */
	protected function genSQL()
	{
		if ($this->length) {
			$sql = sprintf('%s %s(%d) %s',
				$this->name,
				$this->type,
				$this->length,
				implode(' ', $this->attrs)
			);
		} else {
			$sql = sprintf('%s %s %s',
				$this->name,
				$this->type,
				implode(' ', $this->attrs)
			);
		}

		return $sql;
	}
}
