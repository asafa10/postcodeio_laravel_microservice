<?php

namespace App\Http\Controllers;

use App\Services\PostCodesIODataService;
use Illuminate\Http\Request;

class PostCodesIOController extends Controller
{
    /**
     * PostCodesIODataService instance.
     *
     * @var class PostCodesIODataService
     */
    protected $postCodesDataService;

    /**
     * PostCodesIOController constructor.
     *
     * @param PostCodesIODataService $service
     */
    public function __construct(PostCodesIODataService $service)
    {
        $this->postCodesDataService = $service;
    }

    /**
     * Finds location per provided post codes and radius.
     *
     * @param Request $request
     * @return mixed|object
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findLocationByPostCode(Request $request)
    {
        $this->validate(
            $request,
            [
                'post_codes' => 'required|array',
                'radius'     => 'integer|min:100|max:2000'
            ]
        );

        return $this->postCodesDataService->bulkReverseGeoCodeFetch(
            $request->input('post_codes'),
            $request->input('radius')
        );
    }
}
