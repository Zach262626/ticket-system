<div class="mb-3 bg-light p-3 rounded">
    <a href="{{ route('home') }}" class="btn btn btn-primary">Home</a>
    <h1 class="text-center">Login {{ $type }}</h1>
    @if($type == 'Tenant')
    @else
    @endif
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1">
    </div>
    {{-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div> --}}
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route($routeBack) }}" class="btn btn-secondary">Register</a>
</div>