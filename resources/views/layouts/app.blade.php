<!DOCTYPE html>
<html lang="en">
<head>
    <head>
    <title>Chef K QuickBooks</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    


    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
        }
        .sidebar a {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar .active {
            background-color: #e9ecef;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header with Profile Dropdown -->
    <div class="d-flex justify-content-between align-items-center px-4" style="height:60px; background:#fff; border-bottom:1px solid #dee2e6;">
        <div>
            <a href="/dashboard" class="fw-bold fs-3 text-decoration-none" style="font-family: 'Monotype Corsiva'; color: #333;">Chef K, Inc.</a>
        </div>
        <div class="dropdown">
            @php
            $u = Auth::user();
            $photoPath = $u?->photo; // stored as profile_photos/<filename>
            $thumb = $photoPath
                ? asset(ltrim($photoPath, '/'))  // works on both localhost & live
                : 'https://ui-avatars.com/api/?name=' . urlencode($u->name ?? 'User');
        @endphp

        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ $thumb }}" alt="Profile Photo" width="40" height="40" class="rounded-circle me-2">
            <div class="d-flex flex-column align-items-start">
                <span class="fw-bold" style="font-size: 1rem;">{{ $u->name ?? 'User' }}</span>
                <span class="text-muted" style="font-size: 0.95rem; margin-top:-2px;">{{ $u->role ?? '' }}</span>
            </div>
        </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                <li><a class="dropdown-item" href="#">Inbox</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Support</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="d-flex">
        <!-- Sidebar -->
    <div class="sidebar p-3">
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="/income" class="{{ request()->is('income*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Income
            </a>
            <a href="/expense" class="{{ request()->is('expense*') ? 'active' : '' }}">
                <i class="bi bi-credit-card-2-back"></i> Expense
            </a>
            
            <a href="/products" class="{{ request()->is('products*') ? 'active' : '' }}">
                <i class="bi bi-box"></i> Products
            </a>

            <a href="/invoices" class="{{ request()->is('invoices*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Invoices
            </a>
            <a href="/reports" class="{{ request()->is('reports*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Reports
            </a>
            
            <!-- Collapsible Payroll Management Section -->
            <div class="mb-2">
                 <a href="#payrollMenu"
                    data-bs-toggle="collapse"
                    role="button"
                   aria-expanded="{{ request()->is('payroll*') || request()->is('employees*') ? 'true' : 'false' }}"
                   aria-controls="payrollMenu"
                    class="{{ request()->is('payroll*') || request()->is('employees*') ? 'active' : '' }}">
                    <i class="bi bi-folder"></i> Payroll
                    </a>
            </div>

        <div class="collapse {{ request()->is('payroll*') || request()->is('employees*') ? 'show' : '' }}" id="payrollMenu">
    <ul class="list-unstyled ps-4 small">
        <li>
            <a href="{{ route('employees.index') }}" class="d-block py-1 {{ request()->is('employees*') ? 'active' : '' }}">
                <i class="bi bi-people me-1"></i> Employees
            </a>
        </li>
        <li>
            <a href="{{ route('payroll.index') }}" class="d-block py-1 {{ request()->is('payroll') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-1"></i> Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('payroll.summary') }}" class="d-block py-1 {{ request()->is('payroll/summary') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-1"></i> Summary
            </a>
        </li>
        
    </ul>
</div>


            
            
            

        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
