<?php

namespace App\Repository;

use App\Models\Url;
use Illuminate\Pagination\LengthAwarePaginator;

interface UrlRepositoryInterface
{
    /**
     * Retrieve the url by user_id & id (key)
     *
     * @param int $user_id
     * @param int $id
     * @return Url
     * @throws \Illuminate\Support\ItemNotFoundException
     */
    public function findByUserAndId(int $user_id, int $id): Url;

    /**
     * Retrieve the url by hash_id
     *
     * @param string $hash_id
     * @return Url
     * @throws \Illuminate\Support\ItemNotFoundException
     */
    public function findByHashId(string $hash_id): Url;

    /**
     * Getting 20 urls list per page by a user
     *
     * @param int $user_id
     * @return LengthAwarePaginator
     */
    public function getList(int $user_id): LengthAwarePaginator;
}
