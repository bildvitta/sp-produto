<?php

namespace BildVitta\SpProduto\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope
{
    /**
     * Global scope to list results by company.
     *
     * @param  Builder  $builder
     * @param  Model  $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = auth()->user();

        if ($user) {
            $builder->where('hub_company_id', $user->company_id);
        }
    }
}
