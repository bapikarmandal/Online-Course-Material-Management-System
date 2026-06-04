@extends('layouts.app')
@section('title', 'Login — ICV Polytechnic')

@push('styles')
<style>
.auth-wrap{min-height:80vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%)}
.auth-card{background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.12);width:100%;max-width:440px;overflow:hidden}
.auth-top{background:var(--navy);padding:32px;text-align:center}
.auth-top h2{color:#fff;font-size:22px;font-weight:700;margin-bottom:6px}
.auth-top p{color:rgba(255,255,255,.6);font-size:14px}
.auth-body{padding:32px}
.form-group{margin-bottom:20px}
.form-label{display:block;font-size:13px;font-weight:600;color:var(--gray-700,#374151);margin-bottom:6px}
.form-input{width:100%;padding:12px 14px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:14px;transition:border-color .2s;outline:none;background:#fff}
.form-input:focus{border-color:var(--navy);box-shadow:0 0 0 3px rgba(0,33,71,.08)}
.form-input.error{border-color:var(--red)}
.input-icon{position:relative}
.input-icon i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray-400);font-size:16px}
.input-icon .form-input{padding-left:38px}
.btn-submit{width:100%;padding:13px;background:var(--navy);color:#fff;border:none;border-radius:var(--radius);font-size:15px;font-weight:700;cursor:pointer;transition:all .2s;margin-top:8px}
.btn-submit:hover{background:#001630;transform:translateY(-1px);box-shadow:0 4px 12px rgba(0,33,71,.25)}
.auth-footer{text-align:center;margin-top:20px;font-size:14px;color:var(--gray-600)}
.auth-footer a{color:var(--blue);font-weight:600}
.divider{display:flex;align-items:center;gap:12px;margin:20px 0;color:var(--gray-400);font-size:12px}
.divider::before,.divider::after{content:'';flex:1;border-top:1px solid var(--gray-200)}
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-top">
            <div style="font-size:40px;margin-bottom:12px">🎓</div>
            <h2>Welcome Back</h2>
            <p>Sign in to your E-Learning Portal account</p>
        </div>
        <div class="auth-body">
            @if(session('status'))
                <div class="flash flash-info">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               class="form-input {{ $errors->has('email') ? 'error' : '' }}" placeholder="you@example.com">
                    </div>
                    @error('email')<p style="color:var(--red);font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required autocomplete="current-password"
                               class="form-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="••••••••">
                    </div>
                    @error('password')<p style="color:var(--red);font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--gray-600);cursor:pointer">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:13px;color:var(--blue);font-weight:500">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Sign In to Portal
                </button>
            </form>
            <div class="divider">or</div>
            <div class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one here</a>
            </div>
            <div style="margin-top:20px;padding:14px;background:var(--gray-50);border-radius:var(--radius);font-size:12px;color:var(--gray-600)">
                <i class="fas fa-shield-alt" style="color:var(--green)"></i>
                Your connection is secure. We never share your personal information.
            </div>
        </div>
    </div>
</div>
@endsection