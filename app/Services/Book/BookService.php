<?php

namespace App\Services\Book;

use App\Repositories\Book\BookRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookService
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Get a listing of book with stores.
     */
    public function get()
    {
        return $this->bookRepository->get();
    }

    /**
     * Find the book by its id with stores.
     *
     * @param int $id
     *
     * @return Book
     */
    public function find($id)
    {
        return $this->bookRepository->find($id);
    }

    /**
     * Save the book. If there is no id it creates
     * a new book, otherwise it will be updated.
     *
     * @param array $bookData
     * @param int|null $id
     *
     * @return Book|array
     */
    public function save($bookData, $id = null)
    {
        try {
            DB::beginTransaction();

            $book = $this->bookRepository->updateOrCreate($id, $bookData);

            if (isset($bookData['stores'])) {
                $book->stores()->sync($bookData['stores']);
            }

            DB::commit();

            return $book;

        } catch (\Throwable $th) {

            Log::error('Saving book. Error: '. $th->getMessage(), $bookData);
            DB::rollBack();

            return [
                'errorMessage' => $th->getMessage(),
            ];
        }
    }

    /**
     * Delete the book by its id and all related stores.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $book = $this->bookRepository->find($id);

        if (!empty($book)) {
            
            $book->stores()->sync([]);
            return $book->delete();
        }

        return false;
    }
}
