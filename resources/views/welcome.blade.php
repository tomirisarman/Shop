@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success" onclick="$(this).hide('1000')">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="tree">
                            @foreach($parentCats as $par)
                                <p>{{ $par->name }}</p>
                                @if(count($par->children))
                                    @include('subCategoryList',['subcategories' => $par->children])
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



