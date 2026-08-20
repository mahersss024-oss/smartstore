@props(['title'])

<h1 {!! $attributes->merge(['class' => 'mb-3 text-xl font-semibold dark:text-white']) !!}}>{{ $title }}</h1>
