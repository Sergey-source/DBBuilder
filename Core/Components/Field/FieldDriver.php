<?php
namespace Core\Components\Field;

use Core\Components\Field\Field;

require_once dirname(dirname(dirname(__DIR__))) . '/settings/field.php';

/**
 * Класс для генерирования объекта класса Field
 * 
 */
class FieldDriver
{
	public function string($name, $length = DEFAULT_STRING_LENGTH)
	{
		return new Field($name, $length, 'VARCHAR');
	}

	public function integer($name, $length = '')
	{
		return new Field($name, $length, 'INT');
	}

	public function boolean($name, $length = '')
	{
		return new Field($name, $length, 'BOOLEAN');
	}

	public function text($name, $length = '')
	{
		return new Field($name, $length, 'TEXT');
	}

	/**
	 * Создаёт поле идентификатор
	 * @param  string $name
	 * @param  string $length
	 * @return Core\Components\Field\Field
	 */
	public function increment($name, $length = '')
	{
		$field = new Field($name, $length, 'INT');
		$field->primaryKey()->autoIncrement();
		return $field;
	}
}
