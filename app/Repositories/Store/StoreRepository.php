<?php

namespace App\Repositories\Store;

use App\Models\Store\Store;

class StoreRepository
{
    private $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function get()
    {
        return $this->store->get();
    }

    public function find($id)
    {
        return $this->store
            ->with('books')
            ->find($id);
    }

    public function updateOrCreate($id, array $storeData)
    {
        return $this->store->updateOrCreate(
            [ 'id' => $id ],
            $storeData
        );
    }

    public function delete($id)
    {
        return $this->store
            ->with('books')
            ->find($id)
            ->delete($id);
    }
}
