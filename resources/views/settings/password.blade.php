@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Change Password</h2>
    <p class="text-muted">Keep your account secure by updating your password regularly.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('settings.password.update') }}">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
        <a href="{{ route('settings') }}" class="btn btn-secondary ms-2">Back to Settings</a>
    </form>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordVisibility = (toggleButton, inputField) => {
            toggleButton.addEventListener('click', function () {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                this.textContent = type === 'password' ? 'Show' : 'Hide';
            });
        };

        const currentPasswordInput = document.getElementById('current_password');
        const newPasswordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        const currentPasswordToggle = document.createElement('button');
        currentPasswordToggle.type = 'button';
        currentPasswordToggle.textContent = 'Show';
        currentPasswordToggle.classList.add('btn', 'btn-outline-secondary', 'btn-sm', 'ms-2');
        currentPasswordInput.parentNode.appendChild(currentPasswordToggle);
        togglePasswordVisibility(currentPasswordToggle, currentPasswordInput);

        const newPasswordToggle = document.createElement('button');
        newPasswordToggle.type = 'button';
        newPasswordToggle.textContent = 'Show';
        newPasswordToggle.classList.add('btn', 'btn-outline-secondary', 'btn-sm', 'ms-2');
        newPasswordInput.parentNode.appendChild(newPasswordToggle);
        togglePasswordVisibility(newPasswordToggle, newPasswordInput);

        const confirmPasswordToggle = document.createElement('button');
        confirmPasswordToggle.type = 'button';
        confirmPasswordToggle.textContent = 'Show';
        confirmPasswordToggle.classList.add('btn', 'btn-outline-secondary', 'btn-sm', 'ms-2');
        confirmPasswordInput.parentNode.appendChild(confirmPasswordToggle);
        togglePasswordVisibility(confirmPasswordToggle, confirmPasswordInput);
    });
</script>