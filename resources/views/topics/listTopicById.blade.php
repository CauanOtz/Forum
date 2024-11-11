@extends('layouts.header')

@section('content')
<div class="container">
    <h1>{{ $topic->title }}</h1>
    <p>{{ $topic->description }}</p>
    <small>Publicado em: {{ $topic->created_at->format('d/m/Y H:i') }}</small>
    <br>
    <small class="question-author">Publicado por: <strong>{{ $topic->post->user->name }}</strong></small>

    <h2>Conteúdo</h2>
    <p>{{ $topic->post->content ?? 'Conteúdo indisponível' }}</p>
    
    <h3>Comentários</h3>
    @if($topic->comments->isNotEmpty())
        <ul>
            @foreach($topic->comments as $comment)
                <li>{{ $comment->content }} - <small>{{ $comment->created_at->format('d/m/Y H:i') }}</small></li>
            @endforeach
        </ul>
    @else
        <p>Sem comentários.</p>
    @endif
</div>
@endsection
