<div class="container">
    <div class="row">
        <div class="col-md-12 p-5">
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