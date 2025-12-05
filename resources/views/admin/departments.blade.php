@extends('layouts.admin')

@section('title', 'Manage Departments')
@section('page-title', 'Manage Departments')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow-y: auto;
    }
    
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .close {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 28px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
    }
    
    .close:hover {
        color: #000;
    }
    /* Ensure modal is above other elements */
    .modal {
        z-index: 9999 !important;
    }
    
    .dataTables_wrapper .dataTables_length select {
        padding: 4px;
        margin: 0 5px;
    }
    .dataTables_wrapper .dataTables_filter input {
        margin-left: 5px;
        padding: 4px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 4px 10px;
        margin: 0 2px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #667eea;
        color: white !important;
        border-color: #667eea;
    }
    .badge {
        background: #667eea;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #333;">Departments</h2>
            <button class="btn-primary modal-trigger" data-modal="addDepartmentModal">
                <i class="fas fa-plus"></i> Add Department
            </button>
        </div>

        <table class="data-table" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Department Name</th>
                    <th>Institute</th>
                    <th>Description</th>
                    <th>Materials</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->institute->name }}</td>
                        <td>{{ $department->description ?? 'N/A' }}</td>
                        <td>
                            <span class="badge">
                                {{ $department->materials_count }}
                            </span>
                        </td>
                        <td>{{ $department->created_at->format('M d, Y') }}</td>
                        <td>
                            <button type="button" class="btn-edit"
                                    data-id="{{ $department->id }}" 
                                    data-name="{{ $department->name }}"
                                    data-institute-id="{{ $department->institute_id }}"
                                    data-description="{{ $department->description ?? '' }}"
                                    style="background: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this department?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="font-size: 12px;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Department Modal -->
<div id="addDepartmentModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Add New Department</h2>
        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Department Name *</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="institute_id">Institute *</label>
                <select name="institute_id" id="institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal" style="background: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-primary">Add Department</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="modal">
    <div class="modal-content" style="background-color: #fefefe; margin: 5% auto; padding: 25px; border: 1px solid #888; width: 80%; max-width: 600px; border-radius: 8px; position: relative;">
        <span class="close close-modal" style="position: absolute; right: 20px; top: 10px; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h2 style="margin-top: 0; color: #333; padding-right: 30px;">Edit Department</h2>
        <form id="editDepartmentForm" method="POST" style="margin-top: 20px;">
            @csrf
            @method('PUT')
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="edit_name" style="display: block; margin-bottom: 5px; font-weight: 500;">Department Name *</label>
                <input type="text" name="name" id="edit_name" required 
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="edit_institute_id" style="display: block; margin-bottom: 5px; font-weight: 500;">Institute *</label>
                <select name="institute_id" id="edit_institute_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="edit_description" style="display: block; margin-bottom: 5px; font-weight: 500;">Description</label>
                <textarea name="description" id="edit_description" rows="3" 
                         style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn-danger close-modal" 
                        style="background: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn-primary" 
                        style="background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                    Update Department
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle edit button clicks - use event delegation for DataTables compatibility
        // Event delegation works even with dynamically created DataTables rows
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            console.log('Edit button clicked');
            
            // Get the department data from the button's data attributes
            const $button = $(this);
            const departmentId = $button.data('id');
            const departmentName = $button.data('name');
            const instituteId = $button.data('institute-id');
            const description = $button.data('description');
            
            console.log('Department data:', {departmentId, departmentName, instituteId, description});
            
            // Validate data
            if (!departmentId) {
                console.error('Department ID is missing!');
                alert('Error: Department ID is missing. Please refresh the page.');
                return false;
            }
            
            // Set the form values
            $('#edit_name').val(departmentName || '');
            $('#edit_institute_id').val(instituteId || '');
            $('#edit_description').val(description || '');
            
            // Set the form action
            $('#editDepartmentForm').attr('action', '/admin/departments/' + departmentId);
            
            // Show the modal - ensure it's visible
            const $modal = $('#editDepartmentModal');
            if ($modal.length === 0) {
                console.error('Edit modal not found!');
                alert('Edit modal not found. Please refresh the page.');
                return false;
            }
            
            // Show modal with explicit display
            $modal.css({
                'display': 'block',
                'z-index': '9999',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('body').css('overflow', 'hidden');
            
            console.log('Modal displayed, current display:', $modal.css('display'));
            
            return false;
        });
        // Initialize DataTable with export buttons
        $('.data-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            pageLength: 10,
            order: [[0, 'desc']],
            responsive: true,
            columnDefs: [
                { orderable: true, targets: [0, 1, 2, 4, 5] },
                { orderable: false, targets: [3, 6] } // Disable sorting on Description and Actions columns
            ],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });

        // Close modal when clicking on X or Cancel button
        $(document).on('click', '.close, .close-modal, .btn-danger.close-modal', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $modal = $(this).closest('.modal');
            console.log('Close button clicked, hiding modal:', $modal[0]);
            
            $modal.fadeOut(200, function() {
                $('body').css('overflow', 'auto');
            });
            
            return false;
        });
        
        // Close modal when clicking outside
        $(document).on('click', '.modal', function(e) {
            if (e.target === this) {
                hideModal($(this).attr('id'));
            }
        });
        
        // Prevent modal from closing when clicking inside modal content
        $(document).on('click', '.modal-content', function(e) {
            e.stopPropagation();
        });
        
        // Function to show modal (kept for backward compatibility)
        function showModal(modalId) {
            const $modal = $('#' + modalId);
            console.log('showModal called for:', modalId, 'Element:', $modal[0]);
            $modal.css('display', 'block');
            $modal.fadeIn(200);
            $('body').css('overflow', 'hidden');
        }
        
        // Function to hide modal
        function hideModal(modalId) {
            $('#' + modalId).fadeOut(200, function() {
                $('body').css('overflow', 'auto');
            });
        }
    });
</script>
@endpush
