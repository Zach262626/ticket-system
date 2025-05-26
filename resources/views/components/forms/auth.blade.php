<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 p-5">
            <form action="{{ route($route) }}" method="POST">
                @csrf
                @if ($login)
                    <x-forms.login :type="$type" />
                @else
                    <x-forms.register :type="$type" />
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>


    </div>
</div>