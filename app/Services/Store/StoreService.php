<?php

namespace App\Services\Store;

use App\Repositories\Store\StoreRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreService
{
    private $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get a listing of stores.
     */
    public function get()
    {
        return $this->storeRepository->get();
    }

    /**
     * Find the store by its id.
     *
     * @param int $id
     *
     * @return Store
     */
    public function find($id)
    {
        return $this->storeRepository->find($id);
    }

    /**
     * Save the store. If there is no id it creates
     * a new resource, otherwise it will be updated.
     *
     * @param array $storeData
     * @param int|null $id
     *
     * @return Store
     */
    public function save($storeData, $id = null)
    {
        try {
            DB::beginTransaction();

            $store = $this->storeRepository->updateOrCreate($id, $storeData);

            if (isset($storeData['books'])) {
                $store->books()->sync($storeData['books']);
            }

            DB::commit();

            return $store;

        } catch (\Throwable $th) {

            Log::error('Saving store. Error: '. $th->getMessage(), $storeData);
            DB::rollBack();

            return [
                'errorMessage' => $th->getMessage(),
            ];
        }
    }

    /**
     * Delete store by its id and also all its relationships.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $store = $this->storeRepository->find($id);

        if (!empty($store)) {
            $store->books()->sync([]);
            return $store->delete();
        }

        return false;
    }
}
