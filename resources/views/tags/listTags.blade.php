@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/Tags.css') }}">
@section('content')
<div class="landing">
    <div class="sidebar">
            <div class="sidebar-menu">
                <h2>MENU</h2>
                <a class="menu-item" onclick="selectMenuItem(this)" href="{{ route('home') }}"><i class="fa-regular fa-compass"></i>Explore Topics</a>
                <a class="menu-item" onclick="selectMenuItem(this)" href="{{ route('showTags') }}"><i class="fa-solid fa-tag"></i>Tags</a>
            </div>
            <div class="sidebar-personalnav">
                <h2>PERSONAL NAVIGATOR</h2>
                    <a href="{{ route('question') }}">
                        <p class="menu-item"><i class="fa-regular fa-circle-question"></i>My Questions</p>
                    </a>
                    <!-- <a href="{{ route('answers') }}">
                        <p class="menu-item"><i class="fa-regular fa-comments"></i>My Answers</p>
                    </a>
                    <a href="{{ route('likes') }}">
                        <p class="menu-item"><i class="fa-regular fa-thumbs-up"></i>My Likes</p>
                    </a>  Sem funcionamento (Em desenvolvimento) -->
            </div>
            <div class="sidebar-premium">

            </div>
        </div>
        <div class="center">
            <h1 class="text-center mb-4 titleTag">Explore Tags</h1>
            <div class="row justify-content-center">
                <div class="containerTag">
                    @if($tags->isNotEmpty())
                        @foreach($tags as $tag)
                            <!-- <div class="col-md-3 mb-4">
                                <div class="card shadow-sm border-light rounded">
                                    <div class="card-body text-center">
                                        <h5 class="card-title mb-2 text-dark">{{ $tag->title }}</h5>
                                        <span class="badge bg-primary">{{ $tag->description ?? 'Sem descrição' }}</span>
                                    </div>
                                </div>
                            </div> -->
                            
                                <div class="cardTag">
                                    <h5 class="cardTagTitle">{{ $tag->title }}</h5>
                                </div>
                            
                        @endforeach
                    @else
                </div>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <strong>Atenção!</strong> Nenhuma tag encontrada.
                        </div>
                    </div>
                @endif
            </div>
        </div>
</div>
@endsection
