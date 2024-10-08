<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Token;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    use Token;
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
        if ($cek) {
            if ($cek->password == $password) {
                $token = $this->getToken();
                if (!empty($token->json()['token'])) {
                    // $request->session()->put('token', $token->json()['token']);
                    Cache::put('token', $token->json()['token']);
                    $request->session()->put('username', $cek->username);
                    $request->session()->put('password', $cek->password);
                    $request->session()->put('nama', $cek->nama);
                    return redirect('/dashboard');
                } else {
                    return back()->withErrors(['message' => 'Gagal mendapatkan Token']);
                }
            } else {
                return back()->withErrors(['password' => 'Password salah']);
            }
        } else {
            return back()->withErrors(['password' => 'Password salah', 'username' => 'User tidak ditemukan']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Cache::forget('token');
        return redirect('/');
    }
}
