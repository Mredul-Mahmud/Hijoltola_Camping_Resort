<?php

namespace App\Interfaces;

interface PackageSearchInterface
{
    public function search(string $term): iterable;
}
