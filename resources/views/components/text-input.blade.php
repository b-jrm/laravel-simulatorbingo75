@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'px-3 bg-white bg-opacity-25 focus:bg-opacity-50 rounded-t-md shadow-sm focus:ring-0 focus:outline-0 focus:border-b-2 focus:border-white text-black focus:font-bold']) !!}>
