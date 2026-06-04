<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Block inactive users
        if (!$user->is_active) {
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect()->route('login')
                             ->withErrors(['email' => 'Your account has been deactivated. Contact admin.']);
        }
        $user->update(['last_login_at' => now()]);

        // Redirect by role
        if ($user->isAdmin())   return redirect()->route('admin.dashboard');
        if ($user->isFaculty()) return redirect()->route('faculty.dashboard');
        return redirect()->route('home');
    }
}