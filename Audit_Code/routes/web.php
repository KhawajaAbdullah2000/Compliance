<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login-view');
})->name('home');

Route::middleware(['auth','is_root_user'])->group(function(){
Route::get('/root_home',[UserController::class,'root_home'])->name('root_home');

}
);

Route::middleware(['auth','is_user'])->group(function(){
     Route::get('/user_home',[UserController::class,'user_home'])->name('user_home');

    }
    );

 Route::get('/logout',[UserController::class,'logout'])->name('logout');

    


Route::get('/add-root-user', [UserController::class,'changepass'])->name('pass');
Route::post('/login', [UserController::class,'login']);
