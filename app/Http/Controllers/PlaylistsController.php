<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\playlists;
use \DB;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

class PlaylistsController extends Controller
{
    //
    public function getPlaylists()
    {
        return DB::table('playlists')->select()->get();
    }

    public function getPlaylistsUser($id)
    {
        return DB::table('playlists')->select()->where('id_user_creator', $id)->get();
    }
    public function createPlaylist()
    {
        $responseArr = ["msg" => ""];


        $fecha = new \DateTime();
        $imagen = $_FILES['file']['name'];
        $imagen_temporal = $_FILES['file']['tmp_name'];
        $imagen = $fecha->getTimestamp() . "_" . $imagen;
        // move_uploaded_file($imagen_temporal, "E:/xampp/htdocs/music-app/src/assets/thumbnail_playlists/" . $imagen);
        move_uploaded_file($imagen_temporal, "/home/ubuntu/music-app/src/assets/thumbnail_playlists/" . $imagen);

        $playlists['id_user_creator'] = $_POST['idUser'];
        $playlists['thumbnail_playlist'] = $imagen;
        $playlists['nombre_playlist'] = $_POST['name'];
        $playlists['descripcion_playlist'] = $_POST['description'];

        $insertPlaylist = DB::table('playlists')->insert($playlists);
        $responseArr['msg'] = "Playlist creada correctamente.";
        return json_encode($responseArr);
    }
    public function getPlaylistForId($id)
    {
        $playlistById = DB::table('playlists')->select()->where('id_playlists', $id)->get();
        // return $playlistById;
        $id_usuario_creador = $playlistById[0]->id_user_creator;
        $nombre_usuario_creador = DB::table('usuarios')->select()->where('id_usuario', $id_usuario_creador)->get();

        $playlistById['nombre_creador'] = $nombre_usuario_creador[0]->nombre_usuario;

        return $playlistById;
        // return DB::table('playlists')->select()->where('id_playlists', $id)->get();
    }

    public function getSongsByIdPlaylist($id)
    {
        return DB::table('playlist')->select()->where('id_playlist', $id)->get();
    }

    public function addSongToPlaylist()
    {
        $responseArr = ["msg" => ""];
        $data = json_decode(file_get_contents("php://input"));

        $totalInSegs = ($data->song->duration->minutes * 60) + $data->song->duration->seconds;
        $playlist['id'] = $data->song->id;
        $playlist['id_playlist'] = $data->idPlaylist;
        $playlist['nombre_cancion'] = $data->song->name;
        $playlist['artista_cancion'] = $data->song->artist;
        $playlist['thumbnail_cancion'] = $data->song->miniature;
        $playlist['duracion_cancion'] = $totalInSegs;


        $insertarCancion = DB::table('playlist')->insert($playlist);
        $responseArr['msg'] = "Cancion agregada correctamente.";

        return json_encode($responseArr);
        // return json_encode($data);
    }
}
