<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Repository\Eloquent\UrlRepository;

class RedirectUrlController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param UrlRepository $repository
     * @return void
     */
    public function __construct(protected UrlRepository $repository)
    {
    }

    /**
     * Find url by hash_id & Redirect to the target url
     *
     * @param string $hash_id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect(string $hash_id)
    {
        return redirect($this->repository->findByHashId($hash_id)->url);
    }
}
