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

    Route::middleware(['permission:Club list'])->group(function () {
       Route::get('clubs', 'ClubController@index')->name('clubs.index');
        Route::get('get-clubs', 'ClubController@getClubs')->name('get.clubs');
    });
    Route::middleware(['permission:Club create'])->group(function () {
        Route::get('clubs/create', 'ClubController@create')->name('clubs.create');
        Route::post('clubs', 'ClubController@store')->name('clubs.store');
    });
    Route::group(['middleware' => ['permission:Club delete']], function () {
        Route::delete('clubs/{id}','ClubController@destroy')->name('clubs.destroy');
    });

    Route::middleware(['permission:Team list'])->group(function () {
        Route::get('teams', 'TeamController@index')->name('teams.index');
        Route::get('get-teams', 'TeamController@getTeams')->name('get.teams');
    });
    Route::middleware(['permission:Team create'])->group(function () {
        Route::get('teams/create', 'TeamController@create')->name('teams.create');
        Route::post('teams', 'TeamController@store')->name('teams.store');
    });
    Route::middleware(['permission:Team edit'])->group(function () {
        Route::get('teams/{id}/create', 'TeamController@edit')->name('teams.edit');
        Route::put('teams/{id}', 'TeamController@update')->name('teams.update');
    });
    Route::group(['middleware' => ['permission:Team delete']], function () {
        Route::delete('teams/{id}','TeamController@destroy')->name('teams.destroy');
    });

    Route::middleware(['permission:Player list'])->group(function () {
        Route::get('players', 'PlayerController@index')->name('players.index');
        Route::get('get-players', 'PlayerController@getPlayers')->name('get.players');
    });
    Route::middleware(['permission:Player create'])->group(function () {
        Route::get('players/create', 'PlayerController@create')->name('players.create');
        Route::post('players', 'PlayerController@store')->name('players.store');
    });
    Route::middleware(['permission:Player edit'])->group(function () {
        Route::get('players/{id}/create', 'PlayerController@edit')->name('players.edit');
        Route::put('players/{id}', 'PlayerController@update')->name('players.update');
    });
    Route::group(['middleware' => ['permission:Player delete']], function () {
        Route::delete('players/{id}','PlayerController@destroy')->name('players.destroy');
    });

    Route::middleware(['permission:Player group list'])->group(function () {
        Route::get('player-groups', 'PlayerGroupController@index')->name('player-groups.index');
        Route::get('/get-player-groups', 'PlayerGroupController@getPlayerGroups')->name('get.player-groups');
    });
    Route::middleware(['permission:Player group create'])->group(function () {
        Route::get('player-groups/create', 'PlayerGroupController@create')->name('player-groups.create');
        Route::post('player-groups', 'PlayerGroupController@store')->name('player-groups.store');
    });
    Route::middleware(['permission:Player group edit'])->group(function () {
        Route::get('player-groups/{id}/create', 'PlayerGroupController@edit')->name('player-groups.edit');
        Route::put('player-groups/{id}', 'PlayerGroupController@update')->name('player-groups.update');
    });
    Route::group(['middleware' => ['permission:Player group delete']], function () {
        Route::delete('player-groups/{id}','PlayerGroupController@destroy')->name('player-groups.destroy');
    });

    Route::middleware(['permission:User list'])->group(function () {
        Route::get('users', 'UserController@index')->name('users.index');
        Route::get('get-users', 'UserController@getSuperAdmins')->name('get.users');
    });
    Route::middleware(['permission:User create'])->group(function () {
        Route::get('users/create', 'UserController@create')->name('users.create');
        Route::post('users', 'UserController@store')->name('users.store');
    });
    Route::group(['middleware' => ['permission:User delete']], function () {
        Route::delete('users/{id}','UserController@destroy')->name('users.destroy');
    });

    Route::group(['middleware' => ['permission:Login other']], function () {
        Route::get('login-as-other/{id}', 'UserController@loginOtherUser')->name('login.other');
    });
    Route::get('logout-other-user', 'UserController@logoutOtherUser')->name('logout.other.user');
    Route::get('logout', 'UserController@logout');
});

