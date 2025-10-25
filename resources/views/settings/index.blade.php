@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Settings</h2>
    <p class="text-muted">Manage your account and system preferences</p>

    <div class="nav nav-tabs" id="settingsTabs" role="tablist">
        <button class="nav-link active" id="app-tab" data-bs-toggle="tab" data-bs-target="#app" type="button" role="tab">Application</button>
        <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button" role="tab">Company</button>
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile & Security</button>
        <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab">Notifications</button>
        <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#integrations" type="button" role="tab">Integrations</button>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="app" role="tabpanel">
            <!-- Application Settings Form -->
            <div class="row">
                <!-- Theme and Notification Settings -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0"><i class="bi bi-gear"></i> Application Preferences</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Customize theme and notification settings.</p>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="darkMode" {{ $darkMode ? 'checked' : '' }}>
                                <label class="form-check-label" for="darkMode">Dark Mode</label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="notifications" {{ $notificationsEnabled ? 'checked' : '' }}>
                                <label class="form-check-label" for="notifications">Enable Notifications</label>
                            </div>
                            <div id="settings-alert" class="alert alert-info mt-3 d-none" role="alert"></div>
                        </div>
                    </div>
                </div>

                <!-- System Settings removed as requested -->
            </div>
        </div>
        <div class="tab-pane fade" id="company" role="tabpanel">
            <!-- Company Settings Form -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="bi bi-building"></i> Company Settings</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Update your company information and preferences.</p>
                            <form id="companySettingsForm">
                                <!-- Company Name and Address -->
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="companyName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="companyAddress" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="companyAddress" name="companyAddress" required>
                                </div>

                                <!-- Save Changes Button -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel">
            <!-- Profile & Security Settings Form -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0"><i class="bi bi-person-circle"></i> Profile & Security</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Update your profile information and password.</p>
                            <form id="profileSettingsForm">
                                <!-- Name and Email -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <!-- Password and Confirm Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                </div>

                                <!-- Save Changes Button -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="notifications" role="tabpanel">
            <!-- Notifications Settings Form -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0"><i class="bi bi-bell"></i> Notifications</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage your notification preferences.</p>
                            <form id="notificationSettingsForm">
                                <!-- Email Notifications -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" {{ $emailNotificationsEnabled ? 'checked' : '' }}>
                                    <label class="form-check-label" for="emailNotifications">Email Notifications</label>
                                </div>

                                <!-- SMS Notifications -->
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="smsNotifications" {{ $smsNotificationsEnabled ? 'checked' : '' }}>
                                    <label class="form-check-label" for="smsNotifications">SMS Notifications</label>
                                </div>

                                <!-- Save Changes Button -->
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="bi bi-save"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="integrations" role="tabpanel">
            <!-- Integrations Settings Form -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0"><i class="bi bi-plug"></i> Integrations</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage your integrations with other services.</p>
                            <form id="integrationsSettingsForm">
                                <!-- API Key -->
                                <div class="mb-3">
                                    <label for="apiKey" class="form-label">API Key</label>
                                    <input type="text" class="form-control" id="apiKey" name="apiKey" required>
                                </div>

                                <!-- Webhook URL -->
                                <div class="mb-3">
                                    <label for="webhookUrl" class="form-label">Webhook URL</label>
                                    <input type="url" class="form-control" id="webhookUrl" name="webhookUrl" required>
                                </div>

                                <!-- Save Changes Button -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const csrfToken = '{{ csrf_token() }}';
    const darkModeToggle = document.getElementById('darkMode');
    const notificationsToggle = document.getElementById('notifications');
    const alertBox = document.getElementById('settings-alert');

    function showMessage(message, type = 'info') {
        if (!alertBox) return;
        alertBox.classList.remove('d-none', 'alert-info', 'alert-success', 'alert-danger');
        alertBox.classList.add(`alert-${type}`);
        alertBox.textContent = message;
        setTimeout(() => {
            alertBox.classList.add('d-none');
        }, 2500);
    }

    function postToggle(url, payload) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Request failed');
            }
            return response.json();
        });
    }

    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            postToggle('{{ route('settings.toggleTheme') }}', { enabled: this.checked })
                .then(data => {
                    showMessage(data.dark_mode ? 'Dark mode enabled.' : 'Dark mode disabled.', 'success');
                })
                .catch(() => {
                    this.checked = !this.checked;
                    showMessage('Unable to update theme preference.', 'danger');
                });
        });
    }

    if (notificationsToggle) {
        notificationsToggle.addEventListener('change', function() {
            postToggle('{{ route('settings.toggleNotifications') }}', { enabled: this.checked })
                .then(data => {
                    showMessage(data.notifications_enabled ? 'Notifications enabled.' : 'Notifications disabled.', 'success');
                })
                .catch(() => {
                    this.checked = !this.checked;
                    showMessage('Unable to update notification preference.', 'danger');
                });
        });
    }
})();
</script>
@endsection