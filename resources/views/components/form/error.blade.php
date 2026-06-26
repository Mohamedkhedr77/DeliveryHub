@props([
    "name" => "required"
])

@error($name)
<p class="text-error text-sm mt-4">{{ $message }}</p>
@enderror