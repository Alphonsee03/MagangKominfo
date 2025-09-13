<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserAuthVerifyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function submit(UserAuthVerifyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'role' => 'admin'])) {
            $request->session()->regenerate();
            return Redirect()->intended('/admin/dashboard');
        } else if (Auth::guard('kasir')->attempt(['email' => $data['email'], 'password' => $data['password'], 'role' => 'kasir'])) {
            $request->session()->regenerate();
            return Redirect()->intended('/kasir/transaksi');
        } else if (Auth::guard('supplier')->attempt(['email' => $data['email'], 'password' => $data['password'], 'role' => 'supplier'])) {
            $request->session()->regenerate();
            return Redirect()->intended('/supplier/dashboard');
        } else {
            return Redirect(route('login'))->with('error', 'Tidak Bisa Login, Coba Ulangi Lagi');
        }
    }

    public function register() {
        return view('auth.register');
    }

    public function submitRegister(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:225',
        'username' => 'required|string|max:25|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|max:12|confirmed',
    ]);

    User::create([
        'nama' => $request->nama,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'kasir',
    ]);

    return redirect()
        ->route('kasir.transaksi.index')
        ->with('success', 'Registrasi berhasil sebagai Kasir!');
}


    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else if (Auth::guard('kasir')->check()) {
            Auth::guard('kasir')->logout();
        } else if (Auth::guard('supplier')->check()) {
            Auth::guard('supplier')->logout();
        }

        return redirect()->route('login')->with('success', 'Terima kasih');
    }

}
