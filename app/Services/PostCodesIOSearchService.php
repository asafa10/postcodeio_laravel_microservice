<?php

namespace App\Services;

class PostCodesIOSearchService
{
    /**
     * Post Codes bulk reverse geocode URL.
     *
     * @var string $postCodesIOBaseURL
     */
    private static $postCodesIOBaseURL = 'https://postcodes.io/postcodes/';

    /**
     * Bulk Reverse geocode location fetch by post codes and radius.
     *
     * @param json $filterCriteria
     * @return bool|string
     */
    public static function fetchLocationsByPostCodes($filterCriteria)
    {
        $url = self::$postCodesIOBaseURL;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $filterCriteria);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
