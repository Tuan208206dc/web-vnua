<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;

class AuthController extends Controller
{
    // Form dang ky
    public function register()
    {
        return view('auth.register');
    }

    // Xu ly dang ky
    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Vui long nhap ho ten.',
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong dung dinh dang.',
            'email.unique' => 'Email nay da duoc su dung.',
            'password.required' => 'Vui long nhap mat khau.',
            'password.min' => 'Mat khau phai co it nhat 8 ky tu.',
            'password.confirmed' => 'Mat khau xac nhan khong khop.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Ghi log dang ky
        Log::info('Nguoi dung dang ky tai khoan', [
            'user_id' => $user->id,
            'email' => $user->email,
            'registered_at' => now()->toDateTimeString(),
        ]);

        // Gui email chao mung
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (Throwable $e) {
            Log::error('Khong gui duoc email chao mung', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Dang ky tai khoan thanh cong. Email chao mung da duoc gui neu dich vu email hoat dong.');
    }

    // Form dang nhap
    public function login()
    {
        return view('auth.login');
    }

    // Xu ly dang nhap
    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong dung dinh dang.',
            'password.required' => 'Vui long nhap mat khau.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            Log::info('Nguoi dung dang nhap thanh cong', [
                'user_id' => $user->id,
                'email' => $user->email,
                'logged_in_at' => now()->toDateTimeString(),
            ]);

            return redirect()->intended(route('home'))
                ->with('success', 'Dang nhap thanh cong.');
        }

        return back()->withErrors([
            'email' => 'Email hoac mat khau khong chinh xac.',
        ])->onlyInput('email');
    }

    // Form quen mat khau
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Gui email dat lai mat khau
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong dung dinh dang.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Da yeu cau gui email dat lai mat khau', [
                'email' => $request->email,
                'requested_at' => now()->toDateTimeString(),
            ]);

            return back()->with('success', 'Lien ket dat lai mat khau da duoc gui den email cua ban.');
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    // Form dat lai mat khau
    public function resetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // Xu ly dat lai mat khau
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'Vui long nhap email.',
            'password.required' => 'Vui long nhap mat khau moi.',
            'password.min' => 'Mat khau phai co it nhat 8 ky tu.',
            'password.confirmed' => 'Mat khau xac nhan khong khop.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                Log::info('Nguoi dung da dat lai mat khau', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'password_changed_at' => now()->toDateTimeString(),
                ]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Dat lai mat khau thanh cong. Hay dang nhap bang mat khau moi.');
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    // Dang xuat
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Dang xuat thanh cong.');
    }
}
