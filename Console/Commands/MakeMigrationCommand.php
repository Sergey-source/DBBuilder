<?php
namespace Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Core\Components\Filesystem\Filesystem;

class MakeMigrationCommand extends Command
{
	/**
	 *
	 * @var Core\Components\Filesystem\Filesystem
	 */
	private $filesystem;

	/**
	 * Путь к директории с каркасами
	 * @var string
	 */
	private $migrations_stubs;

	/**
	 * Путь к директории с миграциями
	 * @var string
	 */
	private $migrations_path;

	public function __construct()
	{
		parent::__construct();

		$this->filesystem = new Filesystem();
		$this->migrations_stubs = dirname(dirname(__DIR__)) . '/Core/Components/Migrations/stubs';
		$this->migrations_path = dirname(dirname(__DIR__)) . '/Migrations/';
	}

	protected function configure()
	{
		$this->setName('make:migration')
			->setDescription('Make migration file')
			->addArgument('migrationName', InputArgument::REQUIRED, 'Pass the name of the migration');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$migration_name = $input->getArgument('migrationName') . 'Migration';
		$content = $this->getMigrationData($migration_name);
		$this->filesystem->put($this->migrations_path . $migration_name . '.php', $content);
		$output->writeln("<info>Created migration:</info> $migration_name");
	}

	/**
	 * Генерирует контент для файла миграции
	 * @return string
	 */
	private function getMigrationData($migration_name)
	{
		$content = $this->filesystem->get($this->migrations_stubs . '/create.stub');
		$content = str_replace('CreateMigration', $migration_name, $content);
		return $content;
	}
}
