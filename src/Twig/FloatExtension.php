<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FloatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('floatval', [$this, 'floatvalFilter']),
        ];
    }

    public function floatvalFilter($value): float
    {
        return (float) $value;
    }
}