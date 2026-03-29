<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Faculty Dashboard') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            width: 250px;
            position: fixed;
            left: 0; top: 0;
            padding-top: 20px;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar a {
            color: white;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background: #f5f7fa;
            min-height: 100vh;
        }
        .top-bar {
            background: white;
            padding: 15px 30px;
            margin: -20px -20px 20px -20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-primary {
            background: #4f46e5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-primary:hover { background: #4338ca; color: white; }
        .btn-danger {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-danger:hover { background: #c0392b; }
        .btn-edit {
            background: #3498db;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
        }
        .btn-edit:hover { background: #2980b9; }
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow-y: auto;
        }
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }
        .close:hover { color: black; }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79,70,229,0.2);
        }
        .alert-success {
            background: #d4edda; color: #155724;
            padding: 15px; border-radius: 5px;
            margin-bottom: 20px; border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da; color: #721c24;
            padding: 15px; border-radius: 5px;
            margin-bottom: 20px; border: 1px solid #f5c6cb;
        }
        table.data-table { border-collapse: collapse; }
        table.data-table thead tr {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        table.data-table th,
        table.data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        table.data-table tbody tr:hover { background: #f8f9fa; }
    </style>
</head>
<body>

    {{-- ── Sidebar ── --}}
    <div class="sidebar">
        <div style="padding:0 20px 30px; border-bottom:1px solid rgba(255,255,255,0.2);">
            <h2 style="color:white; margin:0; font-size:22px;">
                <i class="fas fa-chalkboard-teacher"></i> Faculty Panel
            </h2>
        </div>

        <a href="{{ route('faculty.dashboard') }}"
           class="{{ request()->routeIs('faculty.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('faculty.materials.create') }}"
           class="{{ request()->routeIs('faculty.materials.create') ? 'active' : '' }}">
            <i class="fas fa-upload"></i> Upload Material
        </a>
        <a href="{{ url('/') }}"
           style="margin-top:20px; border-top:1px solid rgba(255,255,255,0.2); padding-top:20px;">
            <i class="fas fa-home"></i> Back to Site
        </a>

        <form method="POST" action="{{ route('logout') }}" style="padding:15px 20px;">
            @csrf
            <button type="submit"
                    style="background:rgba(255,255,255,0.2); color:white; border:none;
                           padding:10px 15px; border-radius:5px; width:100%; cursor:pointer;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    {{-- ── Main Content ── --}}
    <div class="main-content">

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-danger">
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- ── Scripts ── --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {

            // DataTables init
            $('.data-table').each(function () {
                if (!$.fn.dataTable.isDataTable(this)) {
                    $(this).DataTable({
                        pageLength: 25,
                        order: [[0, 'desc']],
                        language: {
                            search: 'Search:',
                            lengthMenu: 'Show _MENU_ entries',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            infoEmpty: 'No entries found',
                        },
                    });
                }
            });

            // Modal open
            $(document).on('click', '.modal-trigger', function () {
                var modalId = $(this).data('modal');
                $('#' + modalId).fadeIn(200);
                $('body').css('overflow', 'hidden');
            });

            // Modal close
            $(document).on('click', '.close-modal', function () {
                $(this).closest('.modal').fadeOut(200);
                $('body').css('overflow', '');
            });

            // Modal backdrop click
            $(document).on('click', '.modal', function (e) {
                if ($(e.target).hasClass('modal')) {
                    $(this).fadeOut(200);
                    $('body').css('overflow', '');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
