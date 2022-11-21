<?php

use App\Http\Livewire\BlogComponent;
use App\Http\Livewire\Chat\ChatmainComponent;
use App\Http\Livewire\Chat\CreatechatComponent;
use App\Http\Livewire\InternshipsComponent;
use App\Http\Livewire\JobsComponent;
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

Route::get('/', function () {
    return redirect()->to('/dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/users', CreatechatComponent::class)->name('users');
    Route::get('/chat{key?}', ChatmainComponent::class)->name('chat');
    Route::get('/news', BlogComponent::class)->name('new');
    Route::get('/internships', InternshipsComponent::class)->name('internships');
    Route::get('/jobs', JobsComponent::class)->name('jobs');
});
