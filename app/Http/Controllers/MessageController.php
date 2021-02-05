<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
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

    public function userList()
    {
        $users = User::latest()->where('id', '!=', Auth::user()->id)->get();
        if (\Request::ajax()) {
            return response()->json([
                'users' => $users
            ], 200);
        }

        abort(404);
    }

    public function usermessage($id)
    {
        $user = User::findOrFail($id);
        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', Auth::user()->id);
            $q->where('to', $id);
            $q->where('type', 0);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', Auth::user()->id);
            $q->where('type', 1);
        })->with('user')->get();

        if (\Request::ajax()) {
            return response()->json([
                'user' => $user,
                'messages' => $messages
            ], 200);
        }

        abort(404);
    }

    public function sendmessage(Request $request)
    {
        if ($request->ajax()) {
            $message = Message::create([
                'to' => $request->userid,
                'from' => Auth::user()->id,
                'message' => $request->message,
                'type' =>  0,
            ]);
            $message = Message::create([
                'to' => $request->userid,
                'from' => Auth::user()->id,
                'message' => $request->message,
                'type' =>  1,
            ]);

            broadcast(new MessageSend($message));

        } else {
            abort(404);
        }
    }

    public function deleteSingleMessage($id)
    {
        if (\Request::ajax()) {
            Message::findOrFail($id)->delete();
            return response()->json([
                'message' => 'Message Deleted Successsfully'
            ], 200);
        } else {
            abort(404);
        }
    }

    public function deleteAllMessage($id)
    {
        if (\Request::ajax()) {
            $messages = Message::where(function ($q) use ($id) {
                $q->where('from', Auth::user()->id);
                $q->where('to', $id);
                $q->where('type', 0);
            })->orWhere(function ($q) use ($id) {
                $q->where('from', $id);
                $q->where('to', Auth::user()->id);
                $q->where('type', 1);
            })->get();

            foreach ($messages as $message) {
                Message::findOrFail($message->id)->delete();
            }
            return response()->json([
                'message' => 'All Message Deleted Successsfully'
            ], 200);
        } else {
            abort(404);
        }
    }
}
