@extends('layouts.app')

@section('title', 'Student Dashboard - ICV Polytechnic')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 border-l-4 border-[#f1c40f]">
            <div class="p-6 sm:p-10 flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-[#002147]">
                        Welcome back, <span class="text-blue-600">{{ Auth::user()->name }}</span>!
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Access your study materials, check latest notices, and manage your profile from here.
                    </p>
                </div>
                <div class="mt-6 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-user-graduate mr-2"></i> Student Account
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300 border-t-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span class="text-gray-400 text-sm">Repository</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Study Materials</h3>
                <p class="text-gray-500 text-sm mb-4">Browse lecture notes, assignments, and lab manuals for your semester.</p>
                <a href="{{ route('materials.index') }}" class="inline-block w-full text-center py-2 px-4 border border-blue-500 text-blue-500 font-semibold rounded hover:bg-blue-50 transition">
                    Browse Files
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300 border-t-4 border-green-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <span class="text-gray-400 text-sm">Account</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">My Profile</h3>
                <p class="text-gray-500 text-sm mb-4">Update your personal details, password, and contact information.</p>
                <a href="#" class="inline-block w-full text-center py-2 px-4 border border-green-500 text-green-500 font-semibold rounded hover:bg-green-50 transition">
                    Edit Profile
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-300 border-t-4 border-purple-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <span class="text-gray-400 text-sm">Updates</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">College Notices</h3>
                <p class="text-gray-500 text-sm mb-4">Check recent announcements regarding exams and holidays.</p>
                <a href="#" class="inline-block w-full text-center py-2 px-4 border border-purple-500 text-purple-500 font-semibold rounded hover:bg-purple-50 transition">
                    View Notices
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-history mr-2 text-gray-400"></i> Recent Activity
                </h3>
            </div>
            <div class="p-6">
                <div class="text-center py-8">
                    <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400 text-2xl">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No recent activity</h3>
                    <p class="mt-1 text-gray-500">You haven't downloaded any materials yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('materials.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#002147] hover:bg-[#003366]">
                            <i class="fas fa-search mr-2"></i> Find Materials
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection