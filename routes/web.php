<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Authenticated\ArticleAuthenticatedController;
use App\Http\Controllers\PublicController;
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

Route::get('/', [PublicController::class, 'index'])->name('index');
Route::get('/{slug}', [PublicController::class, 'show'])->name('article.show');

// auth
Route::prefix('auth')->name('auth.')->group(function () {
  Route::view('register', 'pages.public.auth.register')->name('register.view');
  Route::post('register', [AuthController::class, 'registerAction'])->name('register.action');

  Route::view('login', 'pages.public.auth.login')->name('login.view');
  Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');

  Route::get('logout', [AuthController::class, 'logoutAction'])->name('logout.action');
});

// article
Route::prefix('article')->name('article.')->group(function () {
  Route::get('create', [ArticleAuthenticatedController::class, 'createView'])->name('create.view');
  Route::post('create', [ArticleAuthenticatedController::class, 'createAction'])->name('create.action');

  Route::get('/update/{slug}', [ArticleAuthenticatedController::class, 'updateView'])->name('update.view');
  Route::put('/update/{slug}', [ArticleAuthenticatedController::class, 'updateAction'])->name('update.action');

  Route::get('/delete/{slug}', [ArticleAuthenticatedController::class, 'deleteAction'])->name('delete.action');
  Route::get('/publish/{slug}', [ArticleAuthenticatedController::class, 'publishAction'])->name('publish.action');
});
