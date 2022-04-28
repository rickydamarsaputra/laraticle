<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function registerAction(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $avatar = Storage::disk('public')->putFileAs('avatars', $request->file('avatar'), Str::slug($request->username) . '.' . $request->file('avatar')->getClientOriginalExtension());

        User::insert([
            'avatar'   => $avatar,
            'is_admin' => 0,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('auth.login.view');
    }

    public function loginAction(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('article.create.view');
        } else {
            return redirect()->back();
        }
    }

    public function logoutAction()
    {
        auth()->logout();

        return redirect()->route('index');
    }
}
