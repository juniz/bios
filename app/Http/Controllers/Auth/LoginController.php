<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller{

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->get('username');
        $password = $request->get('password');

        $cek = DB::table('user')
                    ->join('pegawai', 'pegawai.nik', '=', DB::Raw("AES_DECRYPT(id_user, 'nur')"))
                    ->whereRaw("id_user = AES_ENCRYPT('{$username}', 'nur')")
                    ->selectRaw("AES_DECRYPT(id_user, 'nur') as username, AES_DECRYPT(password, 'windi') as password, pegawai.nama")
                    ->first();
        if($cek){
            if($cek->password == $password){
                $request->session()->put('username', $cek->username);
                $request->session()->put('password', $cek->password);
                $request->session()->put('nama', $cek->nama);
                return redirect('/dashboard');
            }else{
                return back()->withErrors(['password' => 'Password salah']);
            }
        }else{
            return back()->withErrors(['password' => 'Password salah', 'username' => 'User tidak ditemukan']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}