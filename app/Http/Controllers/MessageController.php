<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function userList(){
        $users = User::latest()->get();
        return response()->json([
            'users' => $users
        ], 200);
   }
}
