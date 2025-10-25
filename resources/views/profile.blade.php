@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Profile</h2>

    @if (session('success'))
    <div id="flash-message" class="alert alert-success position-fixed top-0 end-0 m-4 shadow" style="z-index: 9999; min-width: 250px;">
        <strong>{{ session('success') }}</strong>
        <div class="progress mt-2" style="height: 4px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%; animation: progressOut 3s linear;"></div>
        </div>
    </div>

    <style>
        @keyframes progressOut {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                setTimeout(() => flash.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    @if (session('error'))
    <div id="flash-error" class="alert alert-danger position-fixed top-0 end-0 m-4 shadow" style="z-index: 9999; min-width: 250px;">
        <strong>{{ session('error') }}</strong>
        <div class="progress mt-2" style="height: 4px;">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; animation: progressOut 3s linear;"></div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-error');
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                setTimeout(() => flash.remove(), 500);
            }
        }, 3000);
    </script>
    @endif
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($user)->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', optional($user)->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Profile Photo</label><br>
           @php
                $path = optional($user)->photo;  // stored as "profile_photos/<filename>"
                $src = $path 
                    ? asset(ltrim($path, '/')) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode(optional($user)->name ?? 'User');
            @endphp

            <img src="{{ $src }}" 
                alt="Profile Photo" 
                width="80" 
                class="rounded mb-2" 
                style="object-fit:cover;">
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
