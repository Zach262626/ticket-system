@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">User Settings</h2>

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

        {{-- Profile Section --}}
        <div class="card mb-4">
            <div class="card-header">Profile</div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings-profile-update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">Profile Picture</div>
            <div class="card-body">
                @if(auth()->user()->profile_picture)
                    <div class="mb-3">
                        <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile Picture"
                            class="img-thumbnail" width="150">
                    </div>
                @endif

                <form method="POST" action="{{ route('settings-profile-picture-update') }}" enctype="multipart/form-data"
                    class="d-inline">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Upload New Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-secondary d-inline-block">Upload Picture</button>
                </form>
                <form method="POST" action="{{ route('settings-profile-picture-delete') }}" id="delete-profile-picture-form"
                    class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger d-inline-block"
                        onclick="return confirm('Are you sure you want to delete your Profile Picture?')">
                        Delete Picture
                    </button>
                </form>
            </div>
        </div>
        {{-- <div class="card mb-4">
            <div class="card-header">Notifications</div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings-notifications') }}">
                    @csrf
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="wantsNotifications" name="wants_notifications"
                            value="1" {{ auth()->user()->wants_notifications ? 'checked' : '' }}>
                        <label class="form-check-label" for="wantsNotifications">
                            Receive notifications
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save Preferences</button>
                </form>
            </div>
        </div> --}}

        <div class="card border-danger">
            <div class="card-body">
                <p>This action cannot be undone.</p>
                <form method="POST" action="{{ route('settings-account-delete') }}" id="delete-account-form">
                    @csrf
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete your account?')">
                        Delete My Account
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection