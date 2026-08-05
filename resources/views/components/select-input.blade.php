@props(['disabled' => false, 'empty' => true])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'px-3 bg-white bg-opacity-25 focus:bg-opacity-50 rounded-t-md shadow-sm focus:ring-0 focus:outline-0 focus:border-b-2 focus:border-white text-black focus:font-bold']) !!}>

    @if($empty)
        <option>...</option>
    @endif

    @foreach($options as $option)
        <option value="{{ $option->value }}">{{ $option->text }}</option>
    @endforeach
    
</select>
