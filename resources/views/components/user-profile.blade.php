@php
    $fontSizeName = 50.0 * ($width / 100);
@endphp
<div class="container-fluid justify-content-center">
    <div class="pb-3">
        <div class="d-flex align-items-center">
            <div class="image">

                <img src="https://loremflickr.com/200/200?random=1" alt="Avatar" class="avatar" width="{{ $width }}"
                    style="vertical-align: middle;  border-radius:50%;" />
            </div>
            <div class="ml-3 w-100">
                <div class="px-2" style="font-size:{{ $fontSizeName }}px;">{{ $user->name }}</div>
                @if ($subname)
                    <div class="px-2">company name</div>
                @endif
            </div>
        </div>
    </div>
</div>