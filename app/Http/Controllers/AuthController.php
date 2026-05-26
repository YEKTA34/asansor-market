<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre alanı zorunludur.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Hesabınız dondurulmuştur. Lütfen yöneticinizle iletişime geçin.']);
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Yönetici paneline hoş geldiniz.');
            }

            return redirect()->route('home')->with('success', 'Giriş başarılı. Keyifli alışverişler dileriz!');
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz e-posta adresi veya şifre hatalı.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanımda.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifre eşleşmedi, tekrar kontrol edin.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'balance' => 250.00,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Hesabınız başarıyla oluşturuldu ve oturum açıldı.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Oturum başarıyla kapatıldı.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Ad Soyad alanı boş bırakılamaz.',
            'email.required' => 'E-posta alanı boş bırakılamaz.',
            'email.unique' => 'Bu e-posta adresi başka bir kullanıcı tarafından kullanılıyor.',
            'password.min' => 'Yeni şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifreler uyuşmuyor.',
            'current_password.required_with' => 'Şifrenizi değiştirmek için mevcut şifrenizi girmeniz gerekir.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mevcut şifreniz hatalı.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    public function deactivate()
    {
        $user = Auth::user();
        
        $user->is_active = false;
        $user->save();

        Auth::logout();

        return redirect()->route('home')->with('success', 'Üyeliğiniz kendi isteğiniz üzerine pasifleştirilmiştir.');
    }
}
