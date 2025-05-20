<?php

namespace BildVitta\SpProduto\Traits;

trait EnumHelper
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function keys(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function keyValue(): array
    {
        $cases = self::cases();
        $keyValuePairs = [];
        foreach ($cases as $case) {
            $keyValuePairs[$case->name] = $case->getLabel();
        }

        return $keyValuePairs;
    }

    /**
     * Get all enum values as an array.
     */
    public static function toArray(): array
    {
        return self::values();
    }

    /**
     * Get options for a select input.
     */
    public static function toSelectOptions(): array
    {
        return array_map(
            fn (self $type) => [
                'label' => $type->getLabel(),
                'value' => $type->value,
            ],
            self::cases()
        );
    }

    public static function optionsWithParameters(array $options): array
    {
        return collect($options)->map(fn (string $option) => [
            'value' => $option,
            'label' => self::getLabelWithParameter($option),
        ])
            ->toArray();
    }

    public static function getLabelWithParameter(string $value): ?string
    {
        $name = collect(self::cases())->firstWhere('value', $value)?->name;

        return __($name);
    }
}
