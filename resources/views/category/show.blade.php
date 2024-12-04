@extends('layouts.header')
<link rel="stylesheet" href="{{ asset('css/showCategory.css') }}">
@section('content')
    <div class="container">
        <h1>{{ $categories->title }}</h1>

        @if($categories->topics->isNotEmpty())
            <ul>
                @foreach($categories->topics as $topic)
                    <li>
                        <a href="{{ route('listTopicById', $topic->id) }}">
                            {{ $topic->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Não há tópicos nesta categoria.</p>
        @endif
    </div>
@endsection
