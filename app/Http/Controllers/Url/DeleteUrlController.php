<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use App\Http\Requests\Url\DeleteUrlRequest;
use App\Repository\Eloquent\UrlRepository;

class DeleteUrlController extends Controller
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
     * Show the application dashboard.
     *
     * @param UpdateUrlRequest $request
     * @param int $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function delete(DeleteUrlRequest $request, int $id)
    {
        $this->repository->findByUserAndId($request->user()->getKey(), $id)->delete();

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect()->route('home')
            ->with('status', __(':name has been deleted successfully', ['name' => __('Url')]));
    }
}
