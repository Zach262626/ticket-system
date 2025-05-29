@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row  justify-content-center ">
            <div class="col-md-6">
                <div class=" bg-dark px-3 py-2 rounded-top-2 text-light">
                    <h1 class="col bg-dark">Register New Tenant</h1>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('tenant-register') }}" method="POST">
                    @csrf
                    <div class="mb-3 bg-light p-3 rounded">
                        <a href="{{ route('home') }}" class="btn btn btn-primary">Home</a>
                        <div class="mb-3">
                            <label for="InputCompanyName" class="form-label">Company Name</label>
                            <input name='company_name' type="text" class="form-control" id="InputCompanyName"
                                aria-describedby="companyNameHelp" value="{{ old(key: 'company_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputSubDomain" class="form-label">Sub Domain/DB username</label>
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <input name="sub_domain" type="text" class="form-control" id="InputSubDomain"
                                        aria-describedby="SubDomainHelp" value="{{ old(key: 'sub_domain') }}" required />
                                </div>
                                <div class="col-3">
                                    <span id="SubDomainHelp" class="form-text">
                                        .{{ config('tenancy.central_domains')[1] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="InputPassword1" class="form-label">DB Password</label>
                            <input name="password" type="password" class="form-control" id="InputPassword1"
                                value="ThisIsTemporary2025*" required> {{-- !Temporary! --}}
                        </div>
                        <div class="mb-3">
                            <label for="InputComfirmPassword1" class="form-label">Password Comfirmation</label>
                            <input name="password_confirmation" type="password" class="form-control"
                                id="InputComfirmPassword1" value="ThisIsTemporary2025*" required> {{-- !Temporary! --}}
                        </div>
                        {{-- <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="Check1">
                            <label class="form-check-label" for="Check1">Check me out</label>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection