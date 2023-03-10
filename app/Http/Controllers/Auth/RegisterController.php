<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Http\Requests\RegisterRequest;
use Hash;

use App\Models\User;

class RegisterController extends Controller
{
    public function formRegister()
    {
        $data['title']  =   'Registrasi';

        return view('Auth.register', $data);
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'fullname'              =>  'required|max:255|regex:/^[a-zA-Z0-9 ]*$/',
            'email'                 =>  'required|email|unique:users,email',
            'password'              =>  'required|min:6',
            'password_confirmation' =>  'required|min:6|same:password'
        ],
        [
            'fullname.required'                 =>  'Nama Lengkap wajib diisi',
            'fullname.max'                      =>  'Nama Lengkap maksimal 255 karakter',
            'fullname.regex'                    =>  'Nama Lengkap wajib huruf, angka, atau spasi',
            'email.required'                    =>  'Alamat Email wajib diisi',
            'email.email'                       =>  'Alamat Email tidak valid',
            'email.unique'                      =>  'Alamat Email sudah digunakan',
            'password.required'                 =>  'Password wajib diisi',
            'password.min'                      =>  'Password minimal 6 karakter',
            'password_confirmation.required'    =>  'Konfirmasi Password wajib diisi',
            'password_confirmation.min'         =>  'Konfirmasi Password minimal 6 karakter',
            'password_confirmation.same'        =>  'Konfirmasi Password wajib sama dengan Password'
        ]);

        $register           =   new User;
        $register->fullname =   ucwords(strtolower($request->fullname));
        $register->email    =   strtolower($request->email);
        $register->password =   Hash::make($request->password);
        $register->save();

        return redirect()->route('login')->with(['success' => 'Anda Berhasil Registrasi, Silakan Login']);
    }
}
