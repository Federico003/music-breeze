@php
    $isSorted = $currentSort === $field;
    $nextDirection = $isSorted && $currentDirection === 'asc' ? 'desc' : 'asc';
@endphp

<a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'direction' => $nextDirection]) }}" class="underline hover:font-bold">
    {{ $label }}
    @if ($isSorted)
        @if ($currentDirection === 'asc')
            ▲
        @else
            ▼
        @endif
    @endif
</a>
