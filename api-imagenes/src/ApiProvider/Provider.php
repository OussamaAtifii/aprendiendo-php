<?php

namespace App\ApiProvider;

use App\Models\Image;

class Provider
{
    // Add you pixabay key in API_URL
    private const API_URL = "https://pixabay.com/api/?key=&q=murcia";
    private static array $imageList;

    public static function getImages(): array
    {
        $data = file_get_contents(self::API_URL);
        $formatedData = json_decode($data);

        self::$imageList = [];

        foreach ($formatedData->hits as $image) {
            $imageToAdd = new Image(
                $image->webformatURL,
                $image->user,
                $image->likes
            );

            self::$imageList[] = $imageToAdd;
        }

        return self::$imageList;
    }
}
