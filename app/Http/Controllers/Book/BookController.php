<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\SaveRequest;
use App\Services\Book\BookService;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->bookService->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveRequest $request)
    {
        $response = $this->bookService->save($request->validated());

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
        return $this->bookService->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveRequest $request, string $id)
    {
        $response = $this->bookService->save($request->validated(), $id);

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
        return $this->bookService->delete($id);
    }
}
