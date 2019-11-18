<?php
namespace Console;

use Symfony\Component\Console\Application;

use Console\Commands\MigrateCommand;
use Console\Commands\MakeMigrationCommand;

/**
 * Обёртка над классом Symfony\Component\Console\Application
 */
class ConsoleApplication
{
	/**
	 *
	 * @var Symfony\Component\Console\Application
	 */
	private $app;

	public function __construct()
	{
		$this->app = new Application();
		$this->registerCommands();
	}

	public function run()
	{
		$this->app->run();
	}

	private function registerCommands()
	{
		$this->app->add(new MigrateCommand());
		$this->app->add(new MakeMigrationCommand());
	}
}
