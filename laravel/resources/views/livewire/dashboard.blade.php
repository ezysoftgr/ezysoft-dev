
@include('livewire._partials.header', [
           'title' => __('Dashboard'),
           'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
</svg>
',
            'description' => __('Dashboard'),

])

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden  sm:rounded-lg">
            <div class="p-6  bg-white  border-gray-200">
                <span class="text-4xl font-light">
                    <div class="flex gap-4 items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
</svg>




                           {{ __('Hello') }}, {{$user->name}}
                    </div>
                </span>





                <div class="grid grid-cols-2 dashboard_step1 ">
                    <div class="item-dash">
                        <div class="flex gap-4 items-center mb-5">
                    <span class="w-10 h-10  bg-gray-200 border-0 rounded  dark:bg-gray-700 flex items-center justify-center">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
</svg>

                    </span>
                            <div class="text-2xl font-bold dark:text-white">
                                {{ __('API credentials') }}
                            </div>
                        </div>


                        <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 font-light">
                                    {{ __('API KEY') }}
                                </dt>
                                <dd class="text-lg font-semibold mt-1 text-sm">{{$user->api_key}}</dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 font-light">
                                    {{ __('Store ID') }}
                                </dt>
                                <dd class="text-lg font-semibold mt-1 text-sm">
                                    {{$user->id}}
                                </dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 font-light">
                                    {{ __('Account date created') }}

                                </dt>
                                <dd class="text-lg font-semibold mt-1 text-sm">
                                    {{$user->created_at}}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="item-dash">
                        <div class="flex gap-4 items-center mb-5">
                    <span class="w-10 h-10  bg-gray-200 border-0 rounded dark:bg-gray-700 flex items-center justify-center">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
</svg>

                    </span>
                            <div class="text-2xl font-bold dark:text-white">
                                {{ __('Analytics') }}
                            </div>
                        </div>

                        <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 font-light">
                                    {{ __('New Product') }}
                                </dt>
                                <dd class="text-lg font-semibold mt-1">

                                    @if($listImport)
                                        <span class="inline-flex items-center  px-3 rounded-full
                                        text-xs font-medium bg-teal-500 text-white">  {{$listImport}}</span>

                                    @else


                                        <span class="inline-flex items-center  px-3 rounded-full
                                         text-xs font-medium bg-red-500 text-white">   {{$listImport}}</span>


                                    @endif



                                </dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 font-light">
                                    {{ __('Updated products') }}
                                </dt>
                                <dd class="text-lg font-semibold mt-1">

                                    @if($listUpdate)
                                        <span class="inline-flex items-center px-3 rounded-full text-xs
                                        font-medium bg-yellow-500 text-white">{{$listUpdate}}</span>

                                    @else
                                        <span class="inline-flex items-center  px-3 rounded-full
                                        text-xs font-medium bg-red-500 text-white">{{$listUpdate}}</span>
                                    @endif







                                </dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400 font-light">
                                    {{ __('Removed') }}

                                </dt>
                                <dd class="text-lg font-semibold mt-1">



                                    @if($listDelete)

                                        <span class="inline-flex items-center px-3
                                        rounded-full text-xs font-medium bg-gray-500 text-white">
                                            {{$listDelete}}
                                        </span>

                                    @else
                                        <span class="inline-flex items-center   px-3 rounded-full
                                        text-xs font-medium bg-red-500 text-white">{{$listDelete}}</span>
                                    @endif


                                </dd>
                            </div>
                        </dl>

                    </div>
                </div>



                <div class="platforms mt-5 mb-5">


                    <div class="flex gap-4 items-center mb-5">
                    <span class="w-10 h-10 bg-gray-200 border-0 rounded dark:bg-gray-700 flex items-center justify-center">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
</svg>

                    </span>
                        <div class="text-2xl font-bold dark:text-white">
                            {{ __('Platforms') }}
                        </div>
                    </div>


                    <div class="flex gap-4 ">

                        <p class="font-light contact">
                            {{__('Please contact the software developer to provide you with the necessary addons for integration with your e-shop.')}}
                        </p>
                    </div>



                </div>


                <div class="w-full footer-dashboard">
                    <div class="m-auto">
                        <span class="font-normal text-xs">
                            {{__('Version')}}
                        </span>
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs
                         font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                            1.0.1
                        </span>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


