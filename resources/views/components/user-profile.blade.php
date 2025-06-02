@php
    $fontSizeName = 30.0 * ($width / 100);
@endphp

<div class="container-fluid justify-content-start">
    <div class="pb-3">
        <div class="d-flex align-items-center flex-wrap">
            <div class="image me-3"> 
                <img src="https://loremflickr.com/200/200?random=1" alt="Avatar" class="avatar" width="{{ $width }}"
                    style="vertical-align: middle; border-radius:50%; max-width: 100%;" />
            </div>
            <div class="flex-grow-1">
                <div class="text-break" style="font-size: clamp(16px, {{ $fontSizeName }}px, 6vw);">
                    {{ $user->name }}
                </div>
                @if ($subname)
                    <div class="px-2 text-break">company name</div>
                @endif
            </div>
        </div>
    </div>
</div>