<?php

namespace App\Support;

class RiskScheme
{
    public static function all(): array
    {
        return config('risk_schemes');
    }

    public static function for(string $key): array
    {
        $all = self::all();
        return $all[$key] ?? $all['none'];
    }

    public static function values(string $key): array
    {
        return self::for($key)['values'] ?? [];
    }

    public static function display(int $value, string $key): array
    {
        $scheme = self::for($key);

        if (($scheme['named'] ?? false) && isset($scheme['map'][$value])) {
            return $scheme['map'][$value];
        }

        // Fallback: numeric label/class by range
        $label = (string)$value;
        $class = $value >= 5 ? 'text-danger' : ($value >= 3 ? 'text-warning' : 'text-success');

        return ['label' => $label, 'class' => $class];
    }

    public static function isNone(string $key): bool
    {
        return ($key === 'none');
    }
}
