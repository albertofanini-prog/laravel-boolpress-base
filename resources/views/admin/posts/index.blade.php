@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{route('admin.posts.create')}}">Nuovo post</a>
    </div>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Slug</th>
                <th scope="col">Data di pubblicazione</th>
                <th scope="col">Data di creazione</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->slug}}</td>
                        <td>{{$post->published_at}}</td>
                        <td>{{$post->created_at}}</td>
                        <td>
                            <a class="btn btn-small btn-warning" href="{{route('admin.posts.edit', $post)}}">Modifica</a>
                        </td>
                    </tr>                
                @endforeach
            </tbody>
        </table>
    </div>

@endsection