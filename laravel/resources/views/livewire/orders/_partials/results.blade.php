<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

        <tr>

            <th scope="col" class="px-6 py-3">
                {{ __('Reference') }}
            </th>

            <th scope="col" class="px-6 py-3">
                {{ __('Customer') }}
            </th>


            <th scope="col" class="px-6 py-3">
                {{ __('Total Paid') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('Total Products') }}
            </th>

            <th scope="col" class="px-6 py-3">
                {{ __('Created at') }}
            </th>

        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">


        @forelse($orders as $order)
            <tr>
                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                {{$order->reference}}

                </td>


                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$order->customer->firstname}} {{$order->customer->lastname}}

                </td>

                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                    {{$order->total_paid}}

                </td>
                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @if($order->countProducts())
                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1">
                             {{$order->countProducts()}}
                        </span>

                    @else
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200 uppercase last:mr-0 mr-1">

                                 {{$order->countProducts()}}
                            </span>
                    @endif

                </td>

                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">

                    {{$order->created_at}}

                </td>

            </tr>




            @endforeach

        </tbody>
    </table>
</div>
