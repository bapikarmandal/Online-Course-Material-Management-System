@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="card">
    <h2 style="margin: 0 0 20px 0; color: #333;">All Users</h2>

    <table class="data-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left;">ID</th>
                <th style="padding: 12px; text-align: left;">Name</th>
                <th style="padding: 12px; text-align: left;">Email</th>
                <th style="padding: 12px; text-align: left;">Role</th>
                <th style="padding: 12px; text-align: left;">Registered</th>
                <th style="padding: 12px; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;">{{ $user->id }}</td>
                    <td style="padding: 12px;">{{ $user->name }}</td>
                    <td style="padding: 12px;">{{ $user->email }}</td>
                    <td style="padding: 12px;">
                        <span style="padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;
                            {{ $user->role == 'admin' ? 'background: #e74c3c; color: white;' : ($user->role == 'faculty' ? 'background: #3498db; color: white;' : 'background: #27ae60; color: white;') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 12px;">{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="padding: 12px;">
                        @if(!$user->isAdmin())
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="font-size: 12px;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @else
                            <span style="color: #999; font-size: 12px;">Cannot delete admin</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
