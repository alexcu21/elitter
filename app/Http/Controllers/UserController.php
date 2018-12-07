<?php

namespace App\Http\Controllers;
Use App\User;
Use App\Conversation;
use Http\Requests\CreateMessageRequest;
use App\PrivateMessage;
use App\Notifications\userFollowed;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($username){


      $user = $this->findByUsername($username);

      return view ('users.show', [
        'user' => $user,

      ]);
    }

    public function follow($username, Request $request){
      $user = $this->findByUsername($username);

      $me = $request->user();

      $me->follows()->attach($user);

      $user->notify(new UserFollowed($me));

      return redirect("/$username")->withSuccess('user followed');
    }

    public function unfollow($username, Request $request){
      $user = $this->findByUsername($username);

      $me = $request->user();

      $me->follows()->detach($user);

      return redirect("/$username")->withSuccess('user unfollowed');
    }

    public function follows($username){
      $user = $this->findByUsername($username);

      return view('users.follows', [
        'user' => $user,
        'follows' => $user->follows,
      ]);
    }

    public function followers($username){
      $user = $this->findByUsername($username);
      return view('users.follows', [
        'user' => $user,
        'follows' => $user->followers,
      ]);
    }

    private function findByUsername($username){
      return User::where('username', $username)->firstOrFail();
    }

    public function socialProfiles(){
      return $this->hasMany(SocialProfile::class);
    }

    public function sendPrivateMessage($username, Request $request){

      $user = $this->findByUsername($username);

      $me = $request->user();
      $message = $request->input('message');

      $conversation = Conversation::between($me, $user);


      $privateMessage = PrivateMessage::create([
          'conversation_id' => $conversation->id,
          'user_id' => $me->id,
          'message' => $message,
      ]);

      return redirect('/conversations/'.$conversation->id);
    }

    public function showConversation(Conversation $conversation){
      $conversation->load('users', 'privateMessages');

      return view('users.conversation', [
        'conversation' => $conversation,
        'user' => auth()->user(),
      ]);
    }

    public function notifications(Request $request){
      return $request->user()->notifications;
    }
}
