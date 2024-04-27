<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\UpdateUrlRequest;
use App\Http\Resources\UrlResource;
use App\Repository\Eloquent\UrlRepository;

class UpdateUrlController extends Controller
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
     * Update the url shortener record
     *
     * @param UpdateUrlRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\App\Http\Resources\UrlResource
     */
    public function update(UpdateUrlRequest $request, int $id)
    {
        $url = $this->repository->findByUserAndId($request->user()->getKey(), $id);

        $url->fill([
            'url' => $request->getUrl(),
        ])->save();

        if ($request->wantsJson()) {
            return new UrlResource($url);
        }

        return redirect()->route('home')
            ->with('status', __(':name has been updated successfully', ['name' => __('Url')]));
    }
}
