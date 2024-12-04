@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/showCategories.css') }}">
@section('content')
<div class="landing">
    @include('layouts.sidebarLeft.sidebar')
    
    <div class="contentCategory">
            <h3 class="titleCategory">Categories</h3>
            <div class="containerCardCategory">
                @forelse ($categories as $category)
                <a href="{{ route('listCategoryById', $category->id) }}" class="">
                    <div class="cardCategory">
                        <h5 class="cardCategoryTitle">{{ $category->title }}</h5>
                        <p class="cardCategoryDescription">{{ $category->description }}</p>
                    </div>
                </a>
                    <!-- <div class="col-md-4 mb-4">
                        <a href="{{ route('listCategoryById', $category->id) }}" class="card-link">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                    <p class="card-text text-muted">{{ $category->description }}</p>
                                </div>
                            </div>
                        </a>
                    </div> -->
                @empty
                    <p class="text-center">No categories found.</p>
                @endforelse
            </div>  
    </div>
    @include('layouts.sidebarRight.sidebar')
</div>
<!-- <div class="container mt-5">
    <h1 class="text-center mb-4">Categories</h1>

    <div class="row">
        @forelse ($categories as $category)
            <div class="col-md-4 mb-4">
                <a href="{{ route('listCategoryById', $category->id) }}" class="card-link">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text text-muted">{{ $category->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center">No categories found.</p>
        @endforelse
    </div>
</div> -->
@endsection
