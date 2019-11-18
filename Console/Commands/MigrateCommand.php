<?php
namespace Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use Core\Components\Migrations\Migrator;

/**
 * Выполняет миграции
 */
class MigrateCommand extends Command
{
	/**
	 * 
	 * @var Core\Components\Migrations\Migrator
	 */
	private $migrator;
	
	public function __construct()
	{
		parent::__construct();
		$this->migrator = new Migrator();
	}

	protected function configure()
	{
		$this->setName('migrate')
			->setDescription('Migrate your migrations')
			->addArgument('migrations_name', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'The name of the migrations to migrate')
			->addOption('--refresh', false, InputOption::VALUE_NONE, 'Migrate with dump your database');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if ($migrations_name = $input->getArgument('migrations_name')) {
			$this->migrate($this->migrator->getMigrations($migrations_name), $input, $output);
		} else {
			$migrations = $this->migrator->getAllMigrations();
			$this->migrate($migrations, $input, $output);
		}
	}

	/**
	 * Выполняет миграции
	 * @param  array $migrations список объектов-миграций, которые надо выполнить
	 * @return 
	 */
	private function migrate($migrations, $input, $output)
	{
		if ($input->getOption('refresh')) {
			foreach ($migrations as $migrate) {
				$migrate->drop();
				$output->writeln('<info>Droped:</info> ' . get_class($migrate));
			}
		}
		
		foreach ($migrations as $migrate) {
			$migrate->up();
			$output->writeln('<info>Migrated:</info> ' . get_class($migrate));
		}
	}
}
