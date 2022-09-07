<?php

namespace BildVitta\SpProduto\Console;

use BildVitta\SpProduto\SpProdutoServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConfigSp extends Command
{
    /**
     * Arguments to vendor config publish.
     *
     * @const array
     */
    private const VENDOR_PUBLISH_CONFIG_PARAMS = [
        '--provider' => SpProdutoServiceProvider::class,
        '--tag' => 'sp-produto-config'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sp-produto:config';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Config the SP Produto';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Configuring SP Produto...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('sp-produto.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } elseif ($this->shouldOverwriteConfig()) {
            $this->info('Overwriting configuration file...');
            $this->publishConfiguration($force = true);
        } else {
            $this->info('Existing configuration was not overwritten');
        }

        $this->info('Finish configuration!');
    }

    /**
     * @param  string  $fileName
     *
     * @return bool
     */
    private function configExists(string $fileName): bool
    {
        return File::exists(config_path($fileName));
    }

    /**
     * @param bool|false $forcePublish
     *
     * @return void
     */
    private function publishConfiguration(bool $forcePublish = false): void
    {
        $params = self::VENDOR_PUBLISH_CONFIG_PARAMS;

        if ($forcePublish === true) {
            $params['--force'] = '';
        }

        $this->call('vendor:publish', $params);
    }

    /**
     * Should overwrite config file.
     *
     * @return bool
     */
    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm('Config file already exists. Do you want to overwrite it?', false);
    }
}
