<div class="mb-3 bg-light p-3 rounded">
    <h1>Login {{ $type }}</h1>
    @if($type == 'Tenant')
    @else
        <label for="exampleInputName" class="form-label">Name</label>
        <input name='name' type="text" class="form-control" id="exampleInputName" aria-describedby="nameHelp">
    @endif
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    {{-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route($routeBack) }}" class="btn btn-secondary">Register</a>
</div>