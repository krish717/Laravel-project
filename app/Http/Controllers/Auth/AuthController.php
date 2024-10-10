<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
       
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
       
        $user = User::where('email', $credentials['email'])->first();
    
       
        if (!$user || $user->password !== $credentials['password']) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
     
        $token = JWTAuth::fromUser($user);
    
       
        return response()->json(['token' => $token, 'message' => 'Login successful!']);
    }
    


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();
            $this->create($request->all());
            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        } catch (Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['registration' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:2'],
            'usertype' => ['required', 'in:user,seller'],
        ], [
            'email.unique' => 'The email has already been taken. Please choose a different one.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'usertype' => $data['usertype'],
        ]);
    }

    public function showChangePasswordForm()
    {
        return view('auth.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:1',
        ]);

        if ($request->current_password !== Auth::user()->password) {
            return redirect()->back()->withErrors(['current_password' => 'The old password does not match.'])->withInput();
        }

        User::whereId(auth()->user()->id)->update(['password' => $request->new_password]);
        return redirect()->back()->with("status", "Password changed successfully!");
    }
}
