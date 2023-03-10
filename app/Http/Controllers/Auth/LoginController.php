<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;

use App\Models\User;

class LoginController extends Controller
{
    public function formLogin()
    {
        $data['title']  =   'Login';

        return view('Auth.login', $data);
    }

    public function postLogin(Request $request)
    {
        $email		=	strtolower($request->email);
        $password	=	$request->password;

        $this->validate($request, [
			'email'		=>	'required|email',
			'password'	=>	'required',
		],
		[
			'email.required'	=>	'Email wajib diisi',
			'email.email'		=>	'Email tidak valid',
			'password.required'	=>	'Password wajib diisi',
		]);

        // Cek Email & Password
		$check	=	Auth::attempt(['email' => $email, 'password' => $password]);

		// Jika data tidak ada
		if(!$check) {
			Auth::logout();
      		return redirect()->route('login')->with(['error' => 'Email atau Password salah']);
		}

		return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
  		return redirect()->route('login');
    }
}
