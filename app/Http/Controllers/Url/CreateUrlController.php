<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\CreateUrlRequest;
use App\Http\Resources\UrlResource;
use App\Repository\Eloquent\UrlRepository;

class CreateUrlController extends Controller
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
     * Create a new url shortener record
     *
     * @param CreateUrlRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\App\Http\Resources\UrlResource
     */
    public function create(CreateUrlRequest $request)
    {
        $url = $this->repository->create([
            'user_id' => $request->user()->getKey(),
            'url' => $request->getUrl(),
        ]);

        if ($request->wantsJson()) {
            return new UrlResource($url);
        }

        return redirect()->route('home')
            ->with('status', __(':name has been created successfully', ['name' => __('Url')]));
    }
}
