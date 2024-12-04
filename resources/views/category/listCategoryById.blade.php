@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/showCategoryById.css') }}">
@section('content')
<div class="landing">
    @include('layouts.sidebarLeft.sidebar')

    <div class="contentCategoryDetails">
        <h3 class="titleCategoryDetails">{{ $categories->title }}</h3>
        <div class="detailsCardCategory">
            <p class="details-description">{{ $categories->description }}</p>
        </div>
    </div>

    @include('layouts.sidebarRight.sidebar')
</div>
@endsection
