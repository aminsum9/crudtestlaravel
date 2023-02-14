<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get_user_by_id($user_id)
    {
        $user = User::where('id','=', $user_id)->first();

        return json_encode([
            'success' => true,
            'message' => 'Data user ditemukan.',
            'data'    => $user
        ]);
    }

    public function get_users()
    {
        $barangs = User::get();

        return json_encode([
            'success' => true,
            'message' => 'Data user ditemukan.',
            'data'    => $barangs
        ]);
    }

    public function create_user(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        if (!empty($name) && !empty($email) && !empty($password)) {

            $find_user = User::where('email', '=', $email)->get();
            if (count($find_user) == 1) {
                return ([
                    'success' => false,
                    'message' => 'Email sudah digunakan.'
                ]);
            }
            $api_key = sha1(time());

            $add_user = User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => Hash::make($password),
            ]);

            if ($add_user) {
                $response = ([
                    'id'  => $add_user['id'],
                    'name'  => $add_user['name'],
                    'email' => $add_user['email'],
                ]);

                return ([
                    'success' => true,
                    'message' => 'Anda berhasil menambah data user',
                    'data'    => $response
                ]);
            } else {
                return ([
                    'success' => false,
                    'message' => 'Anda gagal menambah dara user',
                    'data'    => ''
                ]);
            }
        } else {
            return ([
                'success' => false,
                'message' => 'Mohon lengkapi data yang dibutuhkan',
                'data'    => ''
            ]);
        }
    }

    public function update(Request $request)
    {
        $user_id = $request->input('id');
        
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        if (!empty($user_id) && !empty($name) && !empty($email) && !empty($password)) {

            $find_user = User::where('id', '=', $user_id)->get();
            if (count($find_user) != 1) {
                return ([
                    'success' => false,
                    'message' => 'User tidak ditemukan.'
                ]);
            }

            $update_user = User::where('id', '=', $user_id)->update([
                'name'        => $name,
                'email'       => $email,
                'password'    =>  Hash::make($password),
            ]);

            if ($update_user) {
                $response = ([
                    'name'  => $name,
                    'email' =>  $email,
                    'password' =>  $password,
                    'image' => ''
                ]);

                return ([
                    'success' => true,
                    'message' => 'Anda berhasil melakukan update data user',
                    'data'    => $response
                ]);
            } else {
                return ([
                    'success' => false,
                    'message' => 'Anda gagal melakukan update data user'
                ]);
            }
        } else {
            return ([
                'success' => false,
                'message' => 'Mohon lengkapi data yang dibutuhkan'
            ]);
        }
    }

    public function delete_user(Request $request)
    {

        $user_id = $request->input('id');

        $find_user = User::where(['id' => $user_id])->get();

        if(count($find_user) == 0){
            return json_encode([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ]);
        }

        $delete_user_data = User::where(['id' => $user_id])->delete();

        if($delete_user_data){
            return json_encode([
                'success' => true,
                'message' => 'Berhasil menghapus data user',
            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => 'Gagal menghapus data user',
            ]);
        }
    }
}