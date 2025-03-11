<?php

namespace BildVitta\SpProduto\Scopes\RealEstateDevelopments;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if ($user = auth()->user()) {

            /** @var User $user */
            $hubCompanyIds = [];

            $hubCompanyIds = $user->user_companies()
                ->whereHas('company', function ($query) use ($user) {
                    $query->where('hub_companies.main_company_id', $user->main_company_id)
                        ->orWhere('hub_companies.id', $user->main_company_id);
                })
                ->pluck('company_id');

            if ($hubCompanyIds->contains($user->main_company_id)) {
                $builder->whereHas('hub_company', function ($query) use ($user) {
                    $query->where('hub_companies.main_company_id', $user->main_company_id)
                        ->orWhere('hub_companies.id', $user->main_company_id);
                });
            } else {
                $builder->whereIn('hub_company_id', $hubCompanyIds)
                    ->orWhereHas('sellable_by', function (Builder $query) use ($hubCompanyIds) {
                        $query->whereIn('produto_real_estate_development_companies.id', $hubCompanyIds);
                    });
            }
        }
    }
}
