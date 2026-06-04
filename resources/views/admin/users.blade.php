@extends('layouts.admin')
@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="card">
    <div class="card-head">
        <span class="card-title">All Users ({{ $users->total() }})</span>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Last Login</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($users as $u)
            <tr>
                <td style="font-weight:500">{{ $u->name }}</td>
                <td style="color:var(--gray-500);font-size:13px">{{ $u->email }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.role', $u->id) }}" style="display:inline">
                        @csrf @method('PATCH')
                        <select name="role" onchange="this.form.submit()" style="font-size:12px;padding:4px 8px;border:1px solid var(--gray-200);border-radius:6px;{{ $u->id === auth()->id() ? 'pointer-events:none;opacity:.5' : '' }}">
                            <option value="student" {{ $u->role==='student' ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ $u->role==='faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="admin"   {{ $u->role==='admin'   ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>
                </td>
                <td>
                    <span class="badge {{ $u->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $u->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td style="font-size:12px;color:var(--gray-400)">
                    {{ $u->last_login_at ? $u->last_login_at->format('d M Y, H:i') : 'Never' }}
                </td>
                <td style="font-size:12px;color:var(--gray-400)">{{ $u->created_at->format('d M Y') }}</td>
                <td>
                    @if($u->id !== auth()->id())
                    <div style="display:flex;gap:6px">
                        <form method="POST" action="{{ route('admin.users.toggle', $u->id) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $u->is_active ? 'btn-warning' : 'btn-success' }}"
                                    title="{{ $u->is_active ? 'Deactivate' : 'Activate' }}">
                                <i class="fas fa-{{ $u->is_active ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>
                        @if(!$u->isAdmin())
                        <form method="POST" action="{{ route('admin.users.delete', $u->id) }}"
                              onsubmit="return confirm('Delete user {{ $u->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                    @else
                    <span style="font-size:11px;color:var(--gray-400)">You</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:16px 24px">{{ $users->links() }}</div>
</div>
@endsection