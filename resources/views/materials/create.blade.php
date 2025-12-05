@extends('layouts.app')

@section('title', 'Upload Material')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold mb-6">Upload Study Material</h1>
        
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Material Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="institute_id" class="block text-gray-700 text-sm font-bold mb-2">Institute *</label>
                <select name="institute_id" id="institute_id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Institute</option>
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}" {{ old('institute_id') == $institute->id ? 'selected' : '' }}>
                            {{ $institute->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Department *</label>
                <select name="department_id" id="department_id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Department</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="semester" class="block text-gray-700 text-sm font-bold mb-2">Semester *</label>
                <select name="semester" id="semester" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Semester</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label for="file" class="block text-gray-700 text-sm font-bold mb-2">File * (PDF, DOC, DOCX, PPT, PPTX, TXT - Max 10MB)</label>
                <input type="file" name="file" id="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('materials.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Upload Material
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Load departments based on selected institute
    document.getElementById('institute_id').addEventListener('change', function() {
        const instituteId = this.value;
        const departmentSelect = document.getElementById('department_id');
        
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        
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

