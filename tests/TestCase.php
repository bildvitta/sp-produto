<?php

namespace BildVitta\SpProduto\Tests;

use BildVitta\SpProduto\SpProdutoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SpProdutoServiceProvider::class,
        ];
    }
}
