@props(['name'])

<div class="mb-4">
    <input type="file" id="{{ $name }}" name="{{ $name }}" accept='application/pdf'
        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
</div>
