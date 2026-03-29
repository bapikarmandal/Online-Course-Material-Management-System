@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl border-t-4 border-[#2980b9]">
        
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Create Account</h2>
            <p class="mt-2 text-sm text-gray-600">Join the digital campus community</p>
        </div>

        <form class="mt-8 space-y-4" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label class="text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="John Doe">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="student@example.com">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="********">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="********">
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#2980b9] hover:bg-[#2471a3] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Register Now
            </button>

            <div class="text-center mt-2">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Already registered? Login</a>
            </div>
        </form>
    </div>
</div>
@endsection