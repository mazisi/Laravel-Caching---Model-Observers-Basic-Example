<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     $minutes = 300;
//     //Cache::forget('users');
//     $users = Cache::remember('users', $minutes, function () {
//         return User::get();
//     });

//     return view('welcome', ['users' => $users]);
// });

Route::middleware('throttle:users')->get('/', function () {
    $minutes = 300;
    $users = Cache::remember('users', $minutes, function () {
        return User::get();
    });

    return view('welcome', ['users' => $users]);
});

Route::post('/submit', function () {
    User::create([
        'name' => request('name'),
        'email' => request('email'),
        'password' => bcrypt(Str::random(5))
    ]);
   return redirect('/');
});

Route::get('/delete/{id}', function ($id) {
     User::find($id)->delete();
    return redirect('/');
});
