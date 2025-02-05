<?php

namespace BildVitta\SpProduto\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Escopo genérico para filtrar registros por empresa.
 * Filtra registros de acordo com as empresas vinculadas ao usuário autenticado.
 * Caso alguma das empresas vinculadas seja a empresa principal do usuário, o filtro será feito pela empresa principal.
 * 
 * @arg string $relation Nome do relacionamento com a empresa
 * @arg string $relationField Nome do campo de relacionamento com a empresa
 */
class CompanyScope implements Scope
{
    protected string $relation;
    protected string $relationField;

    public function __construct(string $relation = 'company', string $relationField = 'company_id')
    {
        $this->relation = $relation;
        $this->relationField = $relationField;
    }

    public function apply(Builder $builder, Model $model): void
    {
        if ($user = auth()->user()) {
            /** @var User $user */

            $hubCompanyIds = [];

            $hubCompanyIds = $user->user_companies()
                ->whereHas('company', function ($query) use ($user) {
                    $query->where('main_company', $user->main_company_id)
                        ->orWhere('id', $user->main_company_id);
                })
                ->pluck('company_id');

            if ($hubCompanyIds->contains($user->main_company_id)) {
                $builder->whereHas($this->relation, function ($query) use ($user) {
                    $query->where('main_company_id', $user->main_company_id)
                        ->orWhere('id', $user->main_company_id);
                });
            } else {
                $builder->whereIn($this->relationField, $hubCompanyIds);
            }
        }
    }
}