<?php
namespace Core\Components\Filesystem;

/**
 * Класс для работы с файловой системой
 */
class Filesystem
{
	/**
	 * Вытаскивает содержимое файла
	 * @param  string $path 
	 * @return string
	 */
	public function get($path)
	{
		return file_get_contents($path);
	}

	/**
	 * Записывает содержимое в файл, если он существует, иначе создаёт его
	 * @param  string $path
	 * @param  string $data
	 *
	 */
	public function put($path, $data)
	{
		file_put_contents($path, $data);
	}

	/**
	 * Сканирует директорию по заданному пути
	 * @param  string $path
	 * @return array
	 */
	public function scanDir($path)
	{
		$extra_elements = ['.', '..'];
		$files = scandir($path);

		// Удаляем лишние элементы
		foreach ($files as $file) {
			if (in_array($file, $extra_elements)) {
				unset($files[array_search($file, $files)]);
			}
		}

		return $files;
	}
}
