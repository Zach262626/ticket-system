@extends('layouts.app')
@can('edit roles')
    @section('content')
        <div class="container">
            <div class="container py-5">
                <div class="row">
                    <h1 class="col">Edit Roles and Permissions</h1>
                </div>
                <div class="row">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="row bg-dark px-3 py-2 rounded-1">
                    <div class="col text-light">Role List</div>
                </div>
                <div class="row">
                    <div class="px-4 pt-3 bg-light d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            {{-- <a href="{{ route('role-create') }}" class="btn btn-primary">Create new Role</a> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="px-4 pb-2 bg-light">
                        <form method="POST" action="{{ route('update-roles') }}">
                            @csrf
                            @foreach($roles as $role)
                                <div class="mb-4">
                                    <h5>{{ ucfirst($role->name) }}</h5>
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            <div class="col-6 col-md-4 col-lg-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="permissions[{{ $role->id }}][]" value="{{ $permission->id }}"
                                                        id="role_{{ $role->id }}_permission_{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="role_{{ $role->id }}_permission_{{ $permission->id }}">
                                                        {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endcan