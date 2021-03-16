@extends('app')
@section('title',"記事一覧")
@section("content")
@include('nav')
  <div class="container">
    <form action="{{url('/')}}" method="GET">
    <label for="">タグで検索</label>
    <input type="text"  name="keyword" value="{{$keyword}}">
    <input type="submit" value="検索"  class="btn-primary">
    </form>
    
    @foreach ($articles as $article)
      @include('articles.card')
    @endforeach
  </div>

@endsection

