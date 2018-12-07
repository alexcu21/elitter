@section('title')

@extends('layouts.app')

@section('content')
  <div class="jumbotron text-center">
    <h1>Elitter</h1>
    <nav>
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>

      </ul>
    </nav>
  </div>
  <div class="row">
    <form  action="/messages/create" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <input type="text" name="message" value="" class="form-control @if($errors->has('message')) is-invalid @endif" placeholder="What are you thinking?">
        @if ($errors->any())
          @foreach ($errors->get('message') as $error)
            <div class="invalid-feedback">{{$error}}</div>

          @endforeach
        @endif
        <input type="file" class="form-control-file" name="image">
      </div>
    </form>
  </div>
  <div class="row">
    @forelse($messages as $message)
      <div class="col-6">
        @include('messages.message')
      </div>
    @empty
      <p>There is no featured messages</p>
    @endforelse
    @if(count($messages))
      <div class="mt-2 mx-auto">
        {{$messages->links()}}
      </div>
    @endif
  </div>
@endsection
