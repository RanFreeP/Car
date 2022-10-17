<?php

namespace App\Http\Helpers;

class InputHelper
{

static function clearTags($array): array
{
    $requestArray = [];

    foreach ($array as $key => $field) {
        $requestArray[$key] = strip_tags($field);
        $requestArray[$key] = htmlentities($requestArray[$key], ENT_QUOTES, "UTF-8");
        $requestArray[$key] = htmlspecialchars($requestArray[$key], ENT_QUOTES);
    }

    return $requestArray;
}

}
