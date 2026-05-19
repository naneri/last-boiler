@props(['messages'])

@if ($messages)
    <div {{ $attributes }}>
        @foreach ((array) $messages as $message)
            <div class="text-danger small">{{ $message }}</div>
        @endforeach
    </div>
@endif
