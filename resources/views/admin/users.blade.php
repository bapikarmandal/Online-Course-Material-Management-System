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
                        <div style="display: flex; gap: 5px; align-items: center;">
                            <button type="button" class="btn-edit-user"
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}"
                                    style="background: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
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
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $users->links() }}
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Edit User</h2>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_user_name">Name *</label>
                <input type="text" name="name" id="edit_user_name" required>
            </div>
            <div class="form-group">
                <label for="edit_user_email">Email *</label>
                <input type="email" name="email" id="edit_user_email" required>
            </div>
            <div class="form-group">
                <label for="edit_user_role">Role *</label>
                <select name="role" id="edit_user_role" required>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit button clicks
        document.querySelectorAll('.btn-edit-user').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const userName = this.getAttribute('data-name');
                const userEmail = this.getAttribute('data-email');
                const userRole = this.getAttribute('data-role');
                
                document.getElementById('edit_user_name').value = userName;
                document.getElementById('edit_user_email').value = userEmail;
                document.getElementById('edit_user_role').value = userRole;
                document.getElementById('editUserForm').action = '/admin/users/' + userId;
                
                document.getElementById('editUserModal').style.display = 'block';
            });
        });
        
        // Close modal
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('editUserModal').style.display = 'none';
            });
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('editUserModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
@endsection
