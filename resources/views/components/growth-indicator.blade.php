@props(['growth'])

@php
    $showPercent = isset($growth['percentage']);
    if ($showPercent) {
        $val = $growth['percentage'];
        if ($val == (int)$val) {
            $displayValue = (int)$val . '%';
        } else {
            $displayValue = number_format($val, 1) . '%';
        }
    } elseif ($growth['value'] > 0 && $growth['direction'] === 'up') {
        $displayValue = '+' . $growth['value'];
    } elseif ($growth['value'] > 0 && $growth['direction'] === 'down') {
        $displayValue = '−' . $growth['value'];
    } else {
        $displayValue = '0';
    }
@endphp

<span class="inline-flex items-center text-xs font-medium
    {{ $growth['direction'] === 'up' ? 'text-green-600 dark:text-green-400' : ($growth['direction'] === 'down' ? 'text-red-600 dark:text-red-400' : 'text-gray-400 dark:text-gray-500') }}">
    @if($growth['direction'] === 'up')
        <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
    @elseif($growth['direction'] === 'down')
        <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
    @else
        <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
        </svg>
    @endif
    {{ $displayValue }}
</span>
