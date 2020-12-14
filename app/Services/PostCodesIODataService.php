<?php

namespace App\Services;

class PostCodesIODataService
{
    /**
     * Fetch locations by multiple post codes and radius provided.
     *
     * @param array $postCodes
     * @param integer $radius
     * @return object|mixed
     */
    public  function bulkReverseGeoCodeFetch($postCodes, $radius = null)
    {
        $response = PostCodesIOSearchService::fetchLocationsByPostCodes(
            json_encode(
                [
                    'postcodes' => $postCodes,
                    'radius'    => $radius
                ]
            )
        );

        $postCodeIOResponse = json_decode($response, true);

        return ($postCodeIOResponse['status'] === 200)
            ? $this->normalizeLocationsData($postCodeIOResponse)
            : response()->json(['Something went wrong.', 422]);
    }

    /**
     * Normalize the fetched locations with applying
     * only the name and post code as fetched location data.
     *
     * @param json $postCodeIOResponse
     * @return array
     */
    private function normalizeLocationsData($postCodeIOResponse)
    {
        $filteredLocations = [];

        foreach ($postCodeIOResponse['result'] as $primaryResult) {
            foreach ($primaryResult as $key => $postCodeData) {
                if ($key === 'result' && isset($postCodeData['admin_ward']) && isset($postCodeData['postcode'])) {
                    $filteredLocations[] = [
                        'name'     => $postCodeData['admin_ward'],
                        'postcode' => $postCodeData['postcode']
                    ];
                }
            }
        }

        return !empty($filteredLocations)
            ? $filteredLocations
            : response()->json(['Invalid data provided. Please review your input.'], 422);
    }
}
