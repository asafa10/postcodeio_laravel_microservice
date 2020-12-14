<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\PostCodesIODataService;

class PostCodesIOSearchServiceTest extends TestCase
{
    /**
     * PostCodeIODataService instance.
     * @var PostCodesIODataService
     */
    private $postCodeIODataService;

    /**
     * Initialise the setup.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->postCodeIODataService = new PostCodesIODataService();
    }

    /**
     * Destruct setup and connections.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test getting locations without post codes provided.
     */
    public function testGettingLocationWithEmptyPostCodes()
    {
       $response = $this->postCodeIODataService->bulkReverseGeoCodeFetch([]);

       $this->assertIsArray($response->original);
       $this->assertEquals('Invalid data provided. Please review your input.', $response->original[0]);
    }

    /**
     * Test getting locations with non existing post codes.
     */
    public function testGettingLocationWithNonExistingPostCodes()
    {
        $response = $this->postCodeIODataService->bulkReverseGeoCodeFetch(
            [
                'test1',
                'test2'
            ]
        );

        $this->assertIsArray($response->original);
        $this->assertEquals('Invalid data provided. Please review your input.', $response->original[0]);
    }

    /**
     * Test getting locations with existing post codes.
     */
    public function testGettingLocationWithValidCodes()
    {
        $response = $this->postCodeIODataService->bulkReverseGeoCodeFetch(
            [
                'AL9 5JP'
            ]
        );

        $this->assertIsArray($response);

        $this->assertArrayHasKey('name',     $response[0]);
        $this->assertArrayHasKey('postcode', $response[0]);

        $this->assertEquals('Hatfield Central', $response[0]['name']);
        $this->assertEquals('AL9 5JP',          $response[0]['postcode']);
    }
}
