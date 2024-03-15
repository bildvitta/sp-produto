<?php

namespace BildVitta\SpProduto\Traits;

trait HasStates
{
    public const STATE_LIST = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BH' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraiba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    ];

    public function stateName($attribute = 'state')
    {
        if (isset($this->$attribute)) {
            return $this->STATE_LIST[$this->$attribute];
        }

        return '';
    }

    /**
     * Returns state initials by state name.
     */
    public function stateInitials(?string $attribute = null): ?string
    {
        if (isset($attribute)) {
            return array_search($attribute, $this->STATE_LIST);
        }

        return null;
    }
}
