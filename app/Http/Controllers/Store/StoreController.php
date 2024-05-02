<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\SaveRequest;
use App\Services\Store\StoreService;

class StoreController extends Controller
{
    private $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->storeService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveRequest $request)
    {
        $response = $this->storeService->save($request->validated());

        if (!empty($response['errorMessage'])) {
            return response($response['errorMessage'], 500);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->storeService->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveRequest $request, string $id)
    {
        $response = $this->storeService->save($request->validated(), $id);

        if (!empty($response['errorMessage'])) {
            return response($response['errorMessage'], 500);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->storeService->delete($id);
    }
}
