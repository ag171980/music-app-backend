<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\usuarios;
use \DB;

class MysqlController extends Controller
{
    public function obtenerUsuarios()
    {
        return DB::table('usuarios')->select('id_usuario', 'nombre_usuario', 'email_usuario')->get();
        // return DB::table('usuarios')->select()->where('email_usuario', 'ag19@gmail.com')->get();


        // return DB::table('usuarios')->select('email_usuario', 'ag171980@gmail.com')->get();
        // return usuarios::where("nombre_usuario", "Rodriguez");
    }
    public function obtenerUsuariosPorId($id)
    {
        return DB::table('usuarios')->select('id_usuario', 'nombre_usuario', 'email_usuario')->where('id_usuario', $id)->get();
    }
    public function createAccount()
    {
        $responseArr = ["msg" => ""];

        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email;
        $usuarios = DB::table('usuarios')->select()->where('email_usuario', $email)->get();
        if (count($usuarios) == 0) {
            // $usuario['id_usuario'] = $data->id;
            $usuario['nombre_usuario'] = $data->fullname;
            $usuario['email_usuario'] = $email;
            $usuario['pass_usuario'] = password_hash($data->pass, PASSWORD_DEFAULT);
            $insertar = DB::table('usuarios')->insert($usuario);
            $responseArr['msg'] = "Cuenta registrada correctamente.";
        } else {
            $responseArr['msg'] = "Error: Este email ya esta registrado. Intente con otro nuevamente.";
        }
        return json_encode($responseArr);
    }
    public function login()
    {
        // $responseArr = ["msg" => ""];

        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email;
        $usuarios = DB::table('usuarios')->select()->where('email_usuario', $email)->get();
        $pass = $usuarios[0]->pass_usuario;
        if (count($usuarios) != 0) {
            if (password_verify($data->pass, $pass)) {
                $responseArr['msg'] = "Inicio de sesión exitosa.";
                $responseArr['usuario']['id_usuario'] = $usuarios[0]->id_usuario;
                $responseArr['usuario']['perfil_usuario'] = $usuarios[0]->perfil_usuario;
                $responseArr['usuario']['nombre_usuario'] = $usuarios[0]->nombre_usuario;
                $responseArr['usuario']['email_usuario'] = $usuarios[0]->email_usuario;
            } else {
                $responseArr['msg'] = "Error: Contraseña incorrecta. Intente con otra nuevamente.";
            }
        } else {
            $responseArr['msg'] = "Error: Este email no esta registrado.";
        }
        // return json_encode($responseArr);
        return json_encode($responseArr);
    }
}
