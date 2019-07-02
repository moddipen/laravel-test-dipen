<?php

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
    return redirect('login');
});


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('clubs', 'ClubController')->only([
        'index', 'create', 'store', 'destroy'
    ]);
    Route::get('/get-clubs', 'ClubController@getClubs')->name('get.clubs');

    Route::resource('teams', 'TeamController')->except([
        'show'
    ]);
    Route::get('/get-teams', 'TeamController@getTeams')->name('get.teams');

    Route::resource('players', 'PlayerController')->except([
        'show'
    ]);
    Route::get('/get-players', 'PlayerController@getPlayers')->name('get.players');

    Route::resource('player-groups', 'PlayerGroupController')->except([
        'show'
    ]);
    Route::get('/get-player-groups', 'PlayerGroupController@getPlayerGroups')->name('get.player-groups');

    Route::resource('users', 'UserController')->only([
        'index', 'create', 'store', 'destroy'
    ]);
    Route::get('/get-users', 'UserController@getSuperAdmins')->name('get.users');

    Route::get('login-as-other/{id}', 'UserController@loginOtherUser')->name('login.other');
    Route::get('logout', 'UserController@logout');
    Route::get('logout-other-user', 'UserController@logoutOtherUser')->name('logout.other.user');
});

