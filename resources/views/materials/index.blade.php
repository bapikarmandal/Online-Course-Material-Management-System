@extends('layouts.app')

@section('title', 'Study Materials')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Study Materials</h1>
        @auth
            @if(auth()->user()->isFaculty() || auth()->user()->isAdmin())
                <a href="{{ route('materials.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Upload Material
                </a>
            @endif
        @endauth
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('materials.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Institute</label>
                <select name="institute_id" id="institute_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Institutes</option>
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}" {{ request('institute_id') == $institute->id ? 'selected' : '' }}>
                            {{ $institute->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <select name="department_id" id="department_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Departments</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Semesters</option>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
            </div>
        </form>
    </div>

    @if($materials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materials as $material)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-xl font-semibold mb-2">{{ $material->name }}</h3>
                    <p class="text-gray-600 mb-2"><strong>Institute:</strong> {{ $material->institute->name }}</p>
                    <p class="text-gray-600 mb-2"><strong>Department:</strong> {{ $material->department->name }}</p>
                    <p class="text-gray-600 mb-2"><strong>Semester:</strong> {{ $material->semester }}</p>
                    <p class="text-gray-600 mb-2"><strong>Uploaded by:</strong> {{ $material->uploader->name }}</p>
                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('materials.show', $material) }}" class="text-blue-500 hover:text-blue-700">View Details</a>
                        <span class="text-sm text-gray-500">{{ $material->views }} views</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $materials->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <p class="text-gray-600 text-lg">No materials found. Try adjusting your filters.</p>
        </div>
    @endif
</div>

<script>
    // Load departments based on selected institute
    const instituteSelect = document.getElementById('institute_id');
    const departmentSelect = document.getElementById('department_id');
    const selectedInstituteId = instituteSelect.value;
    const selectedDepartmentId = '{{ request("department_id") }}';

    function loadDepartments(instituteId) {
        departmentSelect.innerHTML = '<option value="">All Departments</option>';
        
        if (instituteId) {
            fetch(`/api/departments?institute_id=${instituteId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = dept.name;
                        if (selectedDepartmentId == dept.id) {
                            option.selected = true;
                        }
                        departmentSelect.appendChild(option);
                    });
                });
        }
    }

    if (selectedInstituteId) {
        loadDepartments(selectedInstituteId);
    }

    instituteSelect.addEventListener('change', function() {
        loadDepartments(this.value);
    });
</script>
@endsection

