@extends('layouts.app')
@section('title', 'Register — ICV Polytechnic')

@push('styles')
<style>
.auth-wrap{min-height:80vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;background:linear-gradient(135deg,#f8fafc 0%,#e2e8f0 100%)}
.auth-card{background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.12);width:100%;max-width:480px;overflow:hidden}
.auth-top{background:var(--blue);padding:32px;text-align:center}
.auth-top h2{color:#fff;font-size:22px;font-weight:700;margin-bottom:6px}
.auth-top p{color:rgba(255,255,255,.7);font-size:14px}
.auth-body{padding:32px}
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:13px;font-weight:600;color:var(--gray-700,#374151);margin-bottom:6px}
.form-input{width:100%;padding:12px 14px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:14px;transition:border-color .2s;outline:none}
.form-input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.08)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.btn-submit{width:100%;padding:13px;background:var(--blue);color:#fff;border:none;border-radius:var(--radius);font-size:15px;font-weight:700;cursor:pointer;transition:all .2s;margin-top:8px}
.btn-submit:hover{background:#1643a3}
.strength-bar{height:4px;border-radius:2px;margin-top:6px;background:var(--gray-200);overflow:hidden}
.strength-fill{height:100%;border-radius:2px;transition:all .3s}
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-top">
            <div style="font-size:40px;margin-bottom:12px">📝</div>
            <h2>Create Your Account</h2>
            <p>Join the ICV Polytechnic digital learning community</p>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="John Doe">
                        @error('name')<p style="color:var(--red);font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone (optional)</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="9876543210">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="student@example.com">
                    @error('email')<p style="color:var(--red);font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Department (optional)</label>
                    <select name="department" class="form-input">
                        <option value="">Select your department</option>
                        <option value="CST" {{ old('department') === 'CST' ? 'selected' : '' }}>Computer Science & Technology</option>
                        <option value="ME"  {{ old('department') === 'ME'  ? 'selected' : '' }}>Mechanical Engineering</option>
                        <option value="EE"  {{ old('department') === 'EE'  ? 'selected' : '' }}>Electrical Engineering</option>
                        <option value="CE"  {{ old('department') === 'CE'  ? 'selected' : '' }}>Civil Engineering</option>
                        <option value="MT"  {{ old('department') === 'MT'  ? 'selected' : '' }}>Metallurgical Engineering</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" required class="form-input" id="pw" placeholder="Min 8 characters" oninput="checkStrength(this.value)">
                        <div class="strength-bar"><div class="strength-fill" id="sf"></div></div>
                        <p id="sw" style="font-size:11px;margin-top:4px;color:var(--gray-400)"></p>
                        @error('password')<p style="color:var(--red);font-size:12px;margin-top:4px">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required class="form-input" placeholder="Repeat password">
                    </div>
                </div>
                <div style="font-size:12px;color:var(--gray-600);margin-bottom:16px;padding:12px;background:var(--gray-50);border-radius:var(--radius)">
                    <i class="fas fa-info-circle" style="color:var(--blue)"></i>
                    By registering, you agree to use this portal for educational purposes only.
                    Your account will be created as a <strong>Student</strong> by default.
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Create My Account
                </button>
            </form>
            <div style="text-align:center;margin-top:20px;font-size:14px;color:var(--gray-600)">
                Already registered? <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function checkStrength(pw) {
    let score = 0;
    if(pw.length >= 8) score++;
    if(/[A-Z]/.test(pw)) score++;
    if(/[0-9]/.test(pw)) score++;
    if(/[^A-Za-z0-9]/.test(pw)) score++;
    const colors = ['','#e74c3c','#f39c12','#27ae60','#1a56db'];
    const labels = ['','Weak','Fair','Strong','Very Strong'];
    const pct    = [0, 25, 50, 75, 100];
    document.getElementById('sf').style.cssText = `width:${pct[score]}%;background:${colors[score]}`;
    document.getElementById('sw').textContent = labels[score];
    document.getElementById('sw').style.color = colors[score];
}
</script>
@endpush