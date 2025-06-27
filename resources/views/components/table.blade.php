@props(['headers' => []])

<div class="overflow-x-auto rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
        <thead class="bg-orange-300 dark:bg-gray-800 text-black dark:text-gray-300 uppercase tracking-wider">
            <tr>
                @foreach ($headers as $header)
                    <th scope="col" class="px-4 py-3 font-semibold">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-orange-100 dark:bg-gray-900 divide-y divide-gray-300 dark:divide-gray-700 text-black">
            {{ $slot }}
        </tbody>
    </table>
</div>
