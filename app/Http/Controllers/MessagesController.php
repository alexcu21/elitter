<?php

namespace App\Http\Controllers;
use App\Message;
use App\Http\Requests\CreateMessageRequest;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;


class MessagesController extends Controller
{
    //
    public function show(Message $message){

      //search messages by id
      //$message = Message::find($id);

      return view ('messages.show', [
        'message' => $message
      ]);
    }

    public function create(CreateMessageRequest $request){
        $user = $request->user();
        $image = $request->file('image')->getRealPath();
        Cloudder::upload($image, null);
        $path = Cloudder::getResult();
        //dd($path);

        $message = Message::create([
          'user_id'  => $user->id,
          'content' => $request->input('message'),
          //'image' => $image->store('messages', 'public'),
          'image' => $path['url'],
        ]);

        return redirect('/messages/'.$message->id);
    }

    public function search(Request $request){
      $query = $request->input('query');

      $messages = Message::search($query)->paginate(10);
      $messages->load('user');

      return view('messages.index', [
        'messages' => $messages,
      ]);
    }

    public function responses(Message $message){
      return $message->responses;
    }

    public function destroy(Message $message){
      //$message = Message::where('id', $id)->firstOrFail();
      $message->delete();

      return redirect('/')->withSuccess('message deleted');
    }
}
