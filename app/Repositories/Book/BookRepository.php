<?php

namespace App\Repositories\Book;

use App\Models\Book\Book;

class BookRepository
{
    private $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function get()
    {
        return $this->book
            ->with('stores')
            ->get();
    }

    public function find($id)
    {
        return $this->book
            ->with('stores')
            ->find($id);
    }

    public function updateOrCreate($id, array $bookData)
    {
        return $this->book->updateOrCreate(
            [ 'id' => $id ],
            $bookData
        );
    }

    public function delete($id)
    {
        return $this->book
            ->find($id)
            ->delete($id);
    }
}
