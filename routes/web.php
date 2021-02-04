<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/userlist', [MessageController::class, 'userList'])->name('user.list');
Route::get('/usermessage/{id}', [MessageController::class, 'usermessage'])->name('user.message');
Route::post('/sendmessage', [MessageController::class, 'sendmessage'])->name('send.message');
Route::delete('/delete/single/message/{id}', [MessageController::class, 'deleteSingleMessage'])->name('delete.single.message');
