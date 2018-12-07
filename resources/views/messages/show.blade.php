@extends('layouts.app')

@section('content')
  <h1>Message Id: {{$message->id}} </h1>
  @include('messages.message')

  <responses :message="{{ $message->id }}"></responses>

@endsection
