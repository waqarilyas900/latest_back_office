@props(['label' => '', 'options' => []])

<div>
    @if ($label)
        <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <select {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm']) }}>
        <option value="">-- Select --</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>
</div>
