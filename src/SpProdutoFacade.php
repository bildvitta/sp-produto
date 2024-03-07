<?php

namespace BildVitta\SpProduto;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

class SpProdutoFacade extends Facade
{
    /**
     * @const string
     */
    private const FACADE_ACCESSOR = 'sp-produto';

    /**
     * Get the registered name of the component.
     *
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return self::FACADE_ACCESSOR;
    }
}
