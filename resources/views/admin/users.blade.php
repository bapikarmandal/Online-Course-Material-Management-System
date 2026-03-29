@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="top-bar">
    <h1 style="margin:0; color:#333;">Manage Users</h1>
    <span style="color:#666;">Welcome, {{ auth()->user()->name }}</span>
</div>

<div class="card">
    <h2 style="margin:0 0 20px; color:#333;">All Users</h2>

    <table class="data-table" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                            $roleColors = [
                                'admin'   => '#e74c3c',
                                'faculty' => '#3498db',
                                'student' => '#27ae60',
                            ];
                            $color = $roleColors[$user->role] ?? '#95a5a6';
                        @endphp
                        <span style="padding:4px 10px; border-radius:12px; font-size:12px;
                                     font-weight:600; background:{{ $color }}; color:white;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        @if(!$user->isAdmin())
                            <form action="{{ route('admin.users.delete', $user->id) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @else
                            <span style="color:#999; font-size:12px;">Protected</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
