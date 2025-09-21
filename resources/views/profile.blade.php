@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Profile</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                $displayUser = $user ?? Auth::user();
            @endphp
            @if(optional($displayUser)->photo)
            <img src="{{ asset('storage/' . $displayUser->photo) }}" 
             alt="Profile Photo" width="80" class="rounded mb-2">
            @else
            <img src="{{ asset('default.png') }}" 
            alt="Default Profile" width="80" class="rounded mb-2">
            @endif

            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
