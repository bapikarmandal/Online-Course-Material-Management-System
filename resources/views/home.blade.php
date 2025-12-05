@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to E-Learning Platform</h1>
        <p class="text-xl text-gray-600">Access and manage study materials online</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">For Students</h3>
            <p class="text-gray-600">Browse and download study materials by institute, department, and semester.</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">For Faculty</h3>
            <p class="text-gray-600">Upload and manage course materials for your students.</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-2">For Administrators</h3>
            <p class="text-gray-600">Manage institutes, departments, users, and all materials.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Quick Search</h2>
        <form action="{{ route('materials.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Institute</label>
                <select name="institute_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Institutes</option>
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select name="department_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Departments</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Semesters</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Dynamic department loading based on institute
    document.querySelector('select[name="institute_id"]').addEventListener('change', function() {
        const instituteId = this.value;
        const departmentSelect = document.querySelector('select[name="department_id"]');
        
        departmentSelect.innerHTML = '<option value="">All Departments</option>';
        
        if (instituteId) {
            fetch(`/api/departments?institute_id=${instituteId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = dept.name;
                        departmentSelect.appendChild(option);
                    });
                });
        }
    });
</script>
@endsection

