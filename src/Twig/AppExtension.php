<?php

namespace App\Twig;
    
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {

    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function priceFilter($number)
    {
        return 'RON ' . number_format($number, 2, '.', ',');
    }


}