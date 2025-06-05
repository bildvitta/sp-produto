<?php

namespace BildVitta\SpProduto\Enums;

use BildVitta\SpProduto\Traits\EnumHelper;

enum StreetType: string
{
    use EnumHelper;

    case STREET = 'street'; // Rua
    case AVENUE = 'avenue'; // Avenida
    case ALLEY = 'alley'; // Alameda
    case ROAD = 'road'; // Estrada
    case PLAZA = 'plaza'; // Praça
    case HIGHWAY = 'highway'; // Rodovia
    case LANE = 'lane'; // Travessa

    //    case AIRPORT = 'airport'; // Aeroporto
    //    case AREA = 'area'; // Área
    //    case FARMHOUSE = 'farmhouse'; // Chácara
    //    case COLONY = 'colony'; // Colônia
    //    case CONDOMINIUM = 'condominium'; // Condomínio
    //    case COMPLEX = 'complex'; // Conjunto
    //    case DISTRICT = 'district'; // Distrito
    //    case ESPLANADE = 'esplanade'; // Esplanada
    //    case STATION = 'station'; // Estação
    //    case SLUM = 'slum'; // Favela
    //    case FARM = 'farm'; // Fazenda
    //    case FAIR = 'fair'; // Feira
    //    case GARDEN = 'garden'; // Jardim
    //    case SLOPE = 'slope'; // Ladeira
    //    case LAKE = 'lake'; // Lago
    //    case LAGOON = 'lagoon'; // Lagoa
    //    case SQUARE = 'square'; // Largo
    //    case HOUSING = 'housing'; // Loteamento
    //    case HILL = 'hill'; // Morro
    //    case CORE = 'core'; // Núcleo
    //    case PARK = 'park'; // Parque
    //    case CATWALK = 'catwalk'; // Passarela
    //    case COURTYARD = 'courtyard'; // Pátio
    //    case BLOCK = 'block'; // Quadra
    //    case REFUGE = 'refuge'; // Recanto
    //    case RESIDENTIAL = 'residential'; // Residencial
    //    case SECTOR = 'sector'; // Setor
    //    case RANCH = 'ranch'; // Sítio
    //    case SECTION = 'section'; // Trecho
    //    case ROUNDABOUT = 'roundabout'; // Trevo
    //    case WAY = 'way'; // Via
    //    case OVERPASS = 'overpass'; // Viaduto
    //    case ALLEYWAY = 'alleyway'; // Viela
    //    case VILLAGE = 'village'; // Vila

    // Método para retornar o nome do logradouro em português
    public function getName(): string
    {
        return __($this->value);
    }

    /**
     * Get the label for each street type.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::STREET => __('street'),
            self::AVENUE => __('avenue'),
            self::ALLEY => __('alley'),
            self::ROAD => __('road'),
            self::PLAZA => __('plaza'),
            self::HIGHWAY => __('highway'),
            self::LANE => __('lane'),
        };
    }
}
