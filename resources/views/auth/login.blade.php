@extends('layouts.app')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-xl border-t-4 border-[#002147]">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-[#002147]">Portal Login</h2>
            <p class="text-sm text-gray-500 mt-2">Access your Course Materials & Dashboard</p>
        </div>
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="student@example.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="••••••••">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">Forgot Password?</a>
                @endif
            </div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-[#002147] hover:bg-[#003366] transition duration-150">SIGN IN</button>
            <div class="text-center mt-4">
                <a href="{{ route('register') }}" class="text-sm text-blue-600 font-medium hover:underline">Not registered yet? Create an Account</a>
            </div>
        </form>
    </div>
</div>
@endsection