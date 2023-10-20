<?php

namespace App\ApiProvider;

use App\Models\Film;

class Provider
{
    private static array $filmList;

    // Add your api key from themoviedb
    private const URL_API = "https://api.themoviedb.org/3/movie/popular?api_key=";

    public static function getFilms(): array
    {
        $data = file_get_contents(self::URL_API);
        $formatedData = json_decode($data);
        // var_dump($formatedData->results);

        self::$filmList = [];
        foreach ($formatedData->results as $film) {
            $filmToAdd = new Film(
                $film->title,
                $film->overview,
                "https://image.tmdb.org/t/p/original{$film->poster_path}",
                $film->vote_count
            );

            self::$filmList[] = $filmToAdd;
        }
        return self::$filmList;
    }
}
