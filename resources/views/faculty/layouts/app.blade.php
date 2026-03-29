<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Faculty Dashboard') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            transition: all 0.3s;
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
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background: #f5f7fa;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        .top-bar {
            background: white;
            padding: 15px 30px;
            margin: -20px -20px 20px -20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .btn-primary {
            background: #4f46e5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #4338ca;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-edit {
            background: #3498db;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-edit:hover {
            background: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
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
        }
        .close:hover {
            color: black;
        }
        .form-group {
            margin-bottom: 20px;
        }
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
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div style="padding: 0 20px 30px 20px; border-bottom: 1px solid rgba(255,255,255,0.2);">
            <h2 style="color: white; margin: 0; font-size: 24px;"><i class="fas fa-chalkboard-teacher"></i> Faculty Panel</h2>
        </div>
        <a href="{{ route('faculty.dashboard') }}" class="{{ request()->routeIs('faculty.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('faculty.materials.create') }}" class="{{ request()->routeIs('faculty.materials.create') ? 'active' : '' }}">
            <i class="fas fa-upload"></i> Upload Material
        </a>
        
        {{-- FIX: Changed route('home') to the root URL ('/') or the new dashboard route ('home.dashboard') --}}
        <a href="/" style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
            <i class="fas fa-home"></i> Back to Site
        </a>
        
        <form method="POST" action="{{ route('logout') }}" style="padding: 15px 20px;">
            @csrf
            <button type="submit" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 10px 15px; border-radius: 5px; width: 100%; cursor: pointer;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables only if not already initialized
            if ($('.data-table').length) {
                $('.data-table').each(function() {
                    if (!$.fn.dataTable.isDataTable(this)) {
                        $(this).DataTable({
                            "pageLength": 25,
                            "order": [[0, "desc"]],
                            "language": {
                                "search": "Search:",
                                "lengthMenu": "Show _MENU_ entries",
                                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                                "infoEmpty": "No entries found",
                                "infoFiltered": "(filtered from _MAX_ total entries)"
                            }
                        });
                    }
                });
            }

            // Modal functionality
            $('.modal-trigger').click(function() {
                var modalId = $(this).data('modal');
                $('#' + modalId).show();
                $('body').css('overflow', 'hidden');
            });

            $('.close-modal').click(function() {
                $(this).closest('.modal').hide();
                $('body').css('overflow', '');
            });

            $(window).click(function(event) {
                if ($(event.target).hasClass('modal')) {
                    $('.modal').hide();
                    $('body').css('overflow', '');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>