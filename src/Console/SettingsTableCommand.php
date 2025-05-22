<?php

namespace Laraeast\LaravelSettings\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;

class SettingsTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'settings:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the settings database table';

    /**
     * Create a new settings table command instance.
     */
    public function __construct(
        protected Filesystem $files,
        protected Composer $composer,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle(): void
    {
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/database.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the session.
     */
    protected function createBaseMigration(): string
    {
        $name = 'create_settings_table';

        $path = $this->laravel->databasePath().'/migrations';

        return $this->laravel['migration.creator']->create($name, $path);
    }
}
