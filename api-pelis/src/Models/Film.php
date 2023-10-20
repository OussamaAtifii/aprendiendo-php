<?php

namespace App\Models;

class Film
{
    public function __construct(
        public string $title,
        public string $overview,
        public string $poster_path,
        public int $vote_count

    ) {
    }
}
