<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\UrlCollection;
use App\Repository\Eloquent\UrlRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
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
     * Show the application dashboard
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request)
    {
        $urls = $this->repository->getList($request->user()->getKey());

        if ($request->wantsJson()) {
            return new UrlCollection($urls);
        }

        return view('url.home', [
            'urls' => $urls,
        ]);
    }

    /**
     * Url form for create/update
     *
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function form(Request $request, int $id = null)
    {
        if (!is_null($id)) {
            $url = $this->repository->findByUserAndId($request->user()->getKey(), $id);
        }

        return view('url.form', [
            'url' => $url ?? null,
            'route' => !empty($url) ? route('url.update', [$url->getKey()]) : route('url.create'),
        ]);
    }
}
