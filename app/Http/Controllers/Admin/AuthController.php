<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm(Request $request)
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email|exists:admins,email',
            'password'  => 'required|string'
        ]);

        // If Not Authenticate
        if (!Auth::guard('admin')->attempt($credentials, request()->filled('remember')))
            return back()->withErrors(__('auth.failed'));

        // Check If Session Url Intended Hasn't Admin Redirect Home Admin
        $intended = redirect()->intended()->getTargetUrl();
        if (!str_contains($intended, 'dashboard')) {
            // Destroy Session Url Intended
            session()->forget('url.intended');
            // Redirect Dashboard Home
            return redirect(route('admin.home'));
        }
        // Redirect Url Intended Dashboard
        return redirect($intended);
    }

    public function logout()
    {
        if (auth('admin')->check()) {
            auth('admin')->logout();
            request()->session()->invalidate();
        }
        return redirect(route('admin.login'));
    }
}
