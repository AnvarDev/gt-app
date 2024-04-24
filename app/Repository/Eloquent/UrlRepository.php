<?php

namespace App\Repository\Eloquent;

use App\Models\Url;
use App\Repository\UrlRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UrlRepository extends BaseRepository implements UrlRepositoryInterface
{
    /**
     * UrlRepository constructor.
     *
     * @param Url $model
     */
    public function __construct(Url $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $user_id
     * @param int $id
     * @return Url
     * @throws \Illuminate\Support\ItemNotFoundException
     */
    public function findByUserAndId(int $user_id, int $id): Url
    {
        return $this->getQueryBuilder()->whereUserId($user_id)->whereKey($id)->firstOrFail();
    }

    /**
     * @param string $hash_id
     * @return Url
     * @throws \Illuminate\Support\ItemNotFoundException
     */
    public function findByHashId(string $hash_id): Url
    {
        return $this->getQueryBuilder()->whereHashId($hash_id)->firstOrFail();
    }

    /**
     * @param int $user_id
     * @return LengthAwarePaginator
     */
    public function getList(int $user_id): LengthAwarePaginator
    {
        return $this->getQueryBuilder()->whereUserId($user_id)
            ->orderByDesc('created_at')->paginate(20);
    }
}
