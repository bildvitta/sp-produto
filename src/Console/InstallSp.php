<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace BildVitta\SpProduto\Console;

use BildVitta\SpProduto\SpProdutoServiceProvider;
use Illuminate\Console\Command;

/**
 * Class InstallSp.
 */
class InstallSp extends Command
{
    /**
     * Arguments to vendor migration publish.
     *
     * @const array
     */
    private const VENDOR_PUBLISH_MIGRATION_PARAMS = [
        '--provider' => SpProdutoServiceProvider::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sp-produto:install';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Install the SP Produto';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Installing SP Produto...');

        $this->info('Publishing migration...');

        if ($this->shouldRunMigrations()) {
            $this->publishMigration();
        }

        $this->info('Finish migration!');

        $this->runMigrations();

        $this->info('Publishing database seeders...');

        if ($this->shouldRunSeeders()) {
            $this->publishSeeders();
            $this->runSeeders();
        }

        $this->info('Finish database seeders!');

        $this->info('Installed SPPackage');
    }

    private function shouldRunMigrations(): bool
    {
        return $this->confirm('Run migrations of SP package? If you have already done this step, do not do it again!');
    }

    private function shouldRunSeeders(): bool
    {
        return $this->confirm('Run seeders of SP package? If you have already done this step, do not do it again!');
    }

    private function publishMigration(): void
    {
        $this->call('vendor:publish', self::VENDOR_PUBLISH_MIGRATION_PARAMS);
    }

    private function runMigrations()
    {
        $this->info('Run migrations.');
        $this->call('migrate');
        $this->info('Finish migrations.');
    }

    private function publishSeeders()
    {
        $this->call('vendor:publish', [
            '--provider' => SpProdutoServiceProvider::class,
            '--tag' => 'seeders',
        ]);
    }

    private function runSeeders()
    {
        $this->info('Run seeders.');
        $this->call('db:seed', [
            '--class' => 'SpProdutoSeeder',
        ]);
        $this->newLine();
        $this->info('Finish seeders.');
    }
}
