@extends('app')
@section('title',"記事一覧")
@section("content")
@include('nav')
  <div class="container">
    <form action="{{url('/')}}" method="GET">
    <p><input type="text"  name="keyword" value="{{$keyword}}"></p>
    <p><input type="submit" value="検索"></p>
</form>
    @foreach ($articles as $article)
      @include('articles.card')
    @endforeach
  </div>

@endsection

