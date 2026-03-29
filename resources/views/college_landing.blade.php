@extends('layouts.app')

@section('title', 'Welcome - ICV Polytechnic')

@section('content')
    <div class="relative bg-gray-900 h-[600px] flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/college-building.jpg') }}" alt="College" class="w-full h-full object-cover opacity-50">
        </div>
        <div class="relative z-10 px-4 max-w-5xl mx-auto">
            <h2 class="text-white text-3xl font-medium mb-2 drop-shadow-md">Welcome to</h2>
            <h1 class="text-white text-5xl md:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-lg leading-tight">
                Iswar Chandra Vidyasagar <br> <span class="text-[#f1c40f]">Polytechnic</span>
            </h1>
            <p class="text-gray-200 text-lg mb-10 max-w-3xl mx-auto leading-relaxed drop-shadow-md">
                (Est. 1957) A premier Government Polytechnic in Jhargram. Affiliated to WBSCTVESD and approved by AICTE. 
                Empowering students with technical excellence.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('home') }}" class="bg-[#f1c40f] text-[#002147] font-bold py-4 px-10 rounded shadow-lg hover:bg-[#d4ac0d] transition transform hover:-translate-y-1 flex items-center justify-center gap-2 text-lg">
                    <i class="fas fa-sign-in-alt"></i> Enter E-Learning Portal
                </a>
                <a href="#" class="bg-transparent border-2 border-white text-white font-bold py-4 px-10 rounded shadow-lg hover:bg-white hover:text-[#002147] transition transform hover:-translate-y-1 flex items-center justify-center gap-2 text-lg">
                    <i class="fas fa-globe"></i> Official Website
                </a>
            </div>
        </div>
    </div>

    <div class="bg-[#002147] py-10 border-b-4 border-[#f1c40f]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-white divide-y md:divide-y-0 md:divide-x divide-gray-600">
                <div class="p-2">
                    <div class="text-5xl font-bold text-[#f1c40f] mb-2">1957</div>
                    <div class="text-sm uppercase tracking-widest text-gray-300">Established</div>
                </div>
                <div class="p-2">
                    <div class="text-5xl font-bold text-[#f1c40f] mb-2">5</div>
                    <div class="text-sm uppercase tracking-widest text-gray-300">Major Departments</div>
                </div>
                <div class="p-2">
                    <div class="text-5xl font-bold text-[#f1c40f] mb-2">30 ACRES</div>
                    <div class="text-sm uppercase tracking-widest text-gray-300">Lush Green Campus</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-gray-500 font-bold uppercase tracking-wide text-sm mb-2">Academics</h3>
            <h2 class="text-4xl font-extrabold text-[#002147] mb-12">Engineering Disciplines</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach([
                    ['icon'=>'laptop-code', 'color'=>'blue', 'name'=>'Computer Science'],
                    ['icon'=>'cogs', 'color'=>'red', 'name'=>'Mechanical Engg.'],
                    ['icon'=>'bolt', 'color'=>'yellow', 'name'=>'Electrical Engg.'],
                    ['icon'=>'flask', 'color'=>'purple', 'name'=>'Metallurgical Engg.'],
                    ['icon'=>'building', 'color'=>'green', 'name'=>'Civil Engineering']
                ] as $dept)
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-2xl transition border-t-4 border-{{ $dept['color'] }}-500 cursor-pointer group">
                    <div class="text-{{ $dept['color'] }}-600 mb-6 text-4xl group-hover:scale-110 transition duration-300"><i class="fas fa-{{ $dept['icon'] }}"></i></div>
                    <h4 class="font-bold text-gray-800 text-lg">{{ $dept['name'] }}</h4>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white py-20 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-[#002147]">Life at ICV Polytechnic Campus</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Sevayatan, Jhargram - A holistic learning environment surrounded by nature.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                    <img src="{{ asset('images/campus-life.jpg') }}" alt="Campus Life" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" onerror="this.src='https://source.unsplash.com/800x600/?students,campus'">
                    <div class="absolute bottom-0 left-0 bg-black/60 text-white px-6 py-4 w-full">
                        <i class="fas fa-map-marker-alt text-[#f1c40f] mr-2"></i> Sprawling 30-Acre Green Campus
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl"><i class="fas fa-bed"></i></div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Student Hostels</h4>
                            <p class="text-gray-600 mt-1">On-campus accommodation including 3 Boys' Hostels and 1 Girls' Hostel with necessary amenities.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl"><i class="fas fa-book"></i></div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Central Library</h4>
                            <p class="text-gray-600 mt-1">Well-stocked library featuring over 23,000 books, journals, and digital resources for academic research.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xl"><i class="fas fa-wifi"></i></div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Digital Campus</h4>
                            <p class="text-gray-600 mt-1">Wi-Fi enabled campus with modern computer labs to support digital learning and technical skill development.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection