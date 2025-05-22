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
            </form>
        </div>

    </div>
</div>