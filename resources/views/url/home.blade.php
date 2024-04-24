@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
                    <div class="float-end">
                        <a class="btn btn-sm btn-secondary" href="{{ route('url.form') }}">
                            {{ __('New Shortened URL') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('ID') }}</th>
                                    <th class="text-center">{{ __('Shortened URL') }}</th>
                                    <th class="text-center d-none d-md-table-cell">{{ __('Created') }}</th>
                                    <th class="text-center d-none d-md-table-cell">{{ __('Updated') }}</th>
                                    <th class="text-center" width="12%" colspan="2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($urls as $url)
                                <tr>
                                    <td class="text-center">{{$url->getKey()}}</td>
                                    <td class="text-center">{{$url->short_url}}</td>
                                    <td class="text-center d-none d-md-table-cell">{{$url->created_at}}</td>
                                    <td class="text-center d-none d-md-table-cell">{{$url->updated_at}}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('url.delete', [$url->getKey()]) }}">
                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary" href="{{ route('url.form', [$url->getKey()]) }}">
                                            {{ __('Edit') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $urls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
