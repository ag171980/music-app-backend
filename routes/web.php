<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
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
    return view('welcome');
});
Route::get('/usuarios', function(){
    return "Solo usuarios";
});

//Usuarios
// Route::get('/usuarios', "App\Http\Controllers\MysqlController@obtenerUsuarios");
// Route::get('usuarios', "App\Http\Controllers\MysqlController@obtenerUsuarios");
Route::get('/usuarios/{id}', "App\Http\Controllers\MysqlController@obtenerUsuariosPorId");

Route::post('/usuarios/createAccount', "App\Http\Controllers\MysqlController@createAccount");
Route::post('/usuarios/login', "App\Http\Controllers\MysqlController@login");

//Playlists

Route::get('/playlists', "App\Http\Controllers\PlaylistsController@getPlaylists");

Route::post('/playlists/createPlaylist', "App\Http\Controllers\PlaylistsController@createPlaylist");
Route::post('/playlists/addSongToPlaylist', "App\Http\Controllers\PlaylistsController@addSongToPlaylist");


Route::get('/playlists/getSongsByIdPlaylist/{id}', "App\Http\Controllers\PlaylistsController@getSongsByIdPlaylist");
Route::get('/playlists/getPlaylistForId/{id}', "App\Http\Controllers\PlaylistsController@getPlaylistForId");
Route::get('/playlists/getPlaylistsUser/{id}', "App\Http\Controllers\PlaylistsController@getPlaylistsUser");
