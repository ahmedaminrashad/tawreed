<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Admin\SendForgetPasswordMail;
use App\Models\Admin;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Session;
use Str;

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

    public function forgotPasswordForm()
    {
        return view('admin.auth.forgot_password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            try {
                Mail::to($admin->email)->send(new SendForgetPasswordMail($token, $admin->email));

                Session::flash('success', 'Reset Password Mail sent successfully');
                return back();
            } catch (Exception $exp) {
                Session::flash('error', 'Reset Password Mail failed to send');
                dd($exp->getMessage());
                return back();
            }
        } else {
            Session::flash('error', "This Email $request->email was not found");
            return back();
        }
    }

    public function forgotPasswordOTPForm()
    {
        return view('admin.auth.forgot_password_otp');
    }

    public function forgotPasswordOTP(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            try {
                Mail::to($admin->email)->send(new SendForgetPasswordMail($token, $admin->email));

                Session::flash('success', 'Reset Password Mail sent successfully');
                return back();
            } catch (Exception $exp) {
                Session::flash('error', 'Reset Password Mail failed to send');
                dd($exp->getMessage());
                return back();
            }
        } else {
            Session::flash('error', "This Email $request->email was not found");
            return back();
        }
    }

    public function resetPasswordForm(Request $request, $token)
    {
        // Validate token
        $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();

        if ($tokenData) {
            return view('admin.auth.reset_password', compact('tokenData'));
        } else {
            Session::flash('error', "Token is invalid");
            return back();
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'     => 'required|string|exists:password_reset_tokens,token',
            'email'     => 'required|exists:admins,email',
            'password'  => 'required|string|min:6|max:191|confirmed'
        ]);

        // Validate token
        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$tokenData) {
            Session::flash('error', "Token is invalid");
            return back();
        }

        // Validate Email 
        $admin = Admin::where('email', $request->email)->first();

        if (empty($admin)) {
            Session::flash('error', 'Admin not found');
            return back();
        }

        $admin->update(['password' => bcrypt($request->password)]);

        DB::table('password_reset_tokens')->where('token', $request->token)->delete();

        Session::flash('success', 'Password changed successfully');
        return redirect(route('admin.login'));
    }
}
