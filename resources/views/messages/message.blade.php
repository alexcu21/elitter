<img src="{{$message->image}}" class="img-thumbnail">
<p class="card-text">
  <div class="text-muted">Escrito por:<a href="/{{ $message->user->username }}">{{ $message->user->name }}</a></div>
  {{$message->content}}
  <a href="/messages/{{$message->id}}">Read More</a>

</p>
<div class="card-text text-muted float-right">
	{{ $message->created_at }}
  <br>
  <form action="/messages/{{$message->id }}" method="post">
    {!! csrf_field() !!}
    <input type="hidden" name="_method" value="delete" />
    <button class="btn btn-danger" type="submit">Delete</button>

</form>

</div>
