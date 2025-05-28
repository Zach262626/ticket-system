@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Assign Roles to User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.assignRoles') }}" method="POST">
                        @csrf

                        {{-- User selector --}}
                        <div class="mb-4">
                            <label for="userSelect" class="form-label">Select User</label>
                            <select name="user_id" id="userSelect" class="form-select" required>
                                <option value="" disabled selected>— Choose a user —</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Roles multi-select --}}
                        <div class="mb-4">
                            <label for="roleSelect" class="form-label">Select Roles</label>
                            <select name="roles[]" id="roleSelect" class="form-select" multiple size="5" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold down Ctrl (Windows) or Cmd (Mac) to select multiple.</div>
                        </div>

                        {{-- Or as checkboxes instead of multi-select --}}
                        {{--
                        <div class="mb-4">
                            <label class="form-label">Select Roles</label>
                            <div class="row">
                                @foreach($roles as $role)
                                <div class="col-6 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]"
                                            value="{{ $role->name }}" id="role-{{ $role->id }}">
                                        <label class="form-check-label" for="role-{{ $role->id }}">
                                            {{ ucfirst($role->name) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        --}}

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Assign Roles
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>