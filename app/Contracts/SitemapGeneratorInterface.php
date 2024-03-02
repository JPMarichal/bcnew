<?php

namespace App\Contracts;

interface SitemapGeneratorInterface {
    public function generate(): string;
}
