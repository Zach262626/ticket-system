<div class="mb-3 bg-light p-3 rounded">
    <h1 class="text-center">Register New {{ $type }}</h1>
    @if($type == 'Tenant')
        <div class="mb-3">
            <label for="InputCompanyName" class="form-label">Company Name</label>
            <input name='company_name' type="text" class="form-control" id="InputCompanyName"
                aria-describedby="companyNameHelp">
        </div>
        <div class="mb-3">
            <label for="InputSubDomain" class="form-label">Sub Domain</label>
            <input name='sub_domain' type="text" class="form-control" id="InputSubDomain" aria-describedby="SubDomainHelp">
        </div>
    @else
        <div class="mb-3">
            <label for="InputCompanyName" class="form-label
                        <label for=" InputName" class="form-label">Name</label>
            <input name='name' type="text" class="form-control" id="InputName" aria-describedby="nameHelp">
        </div>

    @endif
    <div class="mb-3">
        <label for="InputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="InputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="InputPassword1">
    </div>
    {{-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="Check1">
        <label class="form-check-label" for="Check1">Check me out</label>
    </div> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route($routeBack) }}" class="btn btn-secondary">Login</a>
</div>