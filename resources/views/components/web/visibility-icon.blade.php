@props([
    'is_visible' => false
])

<x-icon :name="'fas-eye'" @class([
    'w-5 h-5',
    'text-green-600' => $is_visible,
    'text-red-600' => !$is_visible,
])/>
