<?php

namespace App\Contracts;

interface FeedProcessorInterface
{
    public function processFeed(string $feedUrl): void;
}
