<div class="mb-3 bg-light p-3 rounded">
    <a href="{{ route('home') }}" class="btn btn btn-primary">Home</a>
    <h1 class="text-center">Register New {{ $type }}</h1>
    @if($type == 'Tenant')
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
    @else
        <div class="mb-3">
            <label for="InputName" class="form-label">Name</label>
            <input name='name' type="text" class="form-control" id="InputName" aria-describedby="nameHelp"
                value="{{ old(key: 'name') }}" required>
        </div>
        <div class="mb-3">
            <label for="InputEmail1" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp"
                value="{{ old(key: 'email') }}" required>
        </div>
    @endif
    <div class="mb-3">
        <label for="InputPassword1" class="form-label">@if($type == 'Tenant')DB @endif Password</label>
        <input name="password" type="password" class="form-control" id="InputPassword1" value="ThisIsTemporary2025*"
            required>
    </div>
    <div class="mb-3">
        <label for="InputComfirmPassword1" class="form-label">Password Comfirmation</label>
        <input name="password_confirmation" type="password" class="form-control" id="InputComfirmPassword1"
            value="ThisIsTemporary2025*" required>
    </div>
    {{-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="Check1">
        <label class="form-check-label" for="Check1">Check me out</label>
    </div> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
    @if($type != 'Tenant')
        <a href="{{ route($routeBack) }}" class="btn btn-secondary">Login</a>
    @endif
</div>