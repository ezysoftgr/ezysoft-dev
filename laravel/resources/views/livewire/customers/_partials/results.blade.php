<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

        <tr>

            <th scope="col" class="px-6 py-3">
                {{ __('Firstname') }}
            </th>

            <th scope="col" class="px-6 py-3">
                {{ __('Lastname') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Email') }}
            </th>

            <th scope="col" class="px-6 py-3">
                {{ __('Created at') }}
            </th>

        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">


        @forelse($customers as $customer)
            <tr>
                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                {{$customer->firstname}}

                </td>

                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                    {{$customer->lastname}}

                </td>
                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                    {{$customer->email}}

                </td>

                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                    {{$customer->created_at}}

                </td>

            </tr>




            @endforeach

        </tbody>
    </table>
</div>
