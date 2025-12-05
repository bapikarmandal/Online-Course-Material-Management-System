@extends('layouts.app')

@section('title', $material->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold mb-4">{{ $material->name }}</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-600"><strong>Institute:</strong> {{ $material->institute->name }}</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Department:</strong> {{ $material->department->name }}</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Semester:</strong> {{ $material->semester }}</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Uploaded by:</strong> {{ $material->uploader->name }}</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>File Name:</strong> {{ $material->file_name }}</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>File Size:</strong> {{ number_format($material->file_size / 1024, 2) }} KB</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Views:</strong> {{ $material->views }}</p>
            </div>
            <div>
                <p class="text-gray-600"><strong>Downloads:</strong> {{ $material->downloads }}</p>
            </div>
        </div>

        @if($material->description)
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-2">Description</h3>
                <p class="text-gray-700">{{ $material->description }}</p>
            </div>
        @endif

        <div class="flex gap-4">
            <a href="{{ route('materials.download', $material) }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Download
            </a>
            <a href="{{ route('materials.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Materials
            </a>
            @auth
                @if(auth()->user()->isAdmin() || auth()->user()->id == $material->uploaded_by)
                    <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" 
                          onsubmit="return confirm('Are you sure you want to delete this material?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection

