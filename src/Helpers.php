<?php

namespace MOIREI\Metrics;

use Illuminate\Support\Str;

class Helpers
{
    public static function asDisplayableName(string $name): string{
        return (string)Str::of(
            preg_replace('/(?<!\ )[A-Z]/', ' $0', $name) // add space before all uppercase
        )
        ->replace('-', ' ') // unsluggify
        ->trim()
        ->ucfirst();
    }
}
