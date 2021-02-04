<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function userList(){
        $users = User::latest()->where('id', '!=', Auth::user()->id)->get();
        if (\Request::ajax()) {
            return response()->json([
                'users' => $users
            ], 200);
        }

        abort(404);
   }

   public function usermessage($id){
        $messages = Message::where(function($q) use ($id){
            $q->where('from', Auth::user()->id);
            $q->where('to', $id);
        })->orWhere(function($q) use($id){
            $q->where('from', $id);
            $q->where('to', Auth::user()->id);
        })->with('user')->get();

        // if (\Request::ajax()) {
            return response()->json([
                'messages' => $messages
            ], 200);
        // }

        abort(404);
   }
}
