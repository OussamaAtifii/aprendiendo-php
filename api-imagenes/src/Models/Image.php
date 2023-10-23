<?php

namespace App\Models;

class Image
{
    public function __construct(
        public string $webformatURL,
        public string $user,
        public int $likes
    ) {
    }
}
