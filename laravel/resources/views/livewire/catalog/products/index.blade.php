<div>


@include('livewire._partials.header', [
           'title' => __('Products'),
           'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
</svg>',
            'description' => __('List of products'),
            'add_new' => '',

       ])


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden  sm:rounded-lg">
            <div class="p-10  bg-white  border-gray-200">
                @if($count)

                    <div class="flex justify-between items-center">

                            <div class="search_with flex  w-1/2  items-center gap-4">
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                    </svg>
                                    <div class="text-1xl font-bold dark:text-white">
                                        {{ __('Type') }}


                                    </div>
                                </div>

                                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white
                                border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input id="horizontal-list-radio-license" type="radio" value="1" name="type"  wire:model="type"
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300
                                               focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-license" class="w-full py-3 ms-2 text-sm font-medium
                                         text-gray-900 dark:text-gray-300">   {{ __('For importing') }} </label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input id="horizontal-list-radio-id" type="radio" value="2" name="type"  wire:model="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-id" class="w-full py-3 ms-2 text-sm
                                        font-medium text-gray-900 dark:text-gray-300">   {{ __('For updated') }}</label>
                                        </div>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input id="horizontal-list-radio-military" type="radio" value="3" name="type"  wire:model="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-military" class="w-full
                                         py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">   {{ __('For deleted') }}</label>
                                        </div>
                                    </li>
                                </ul>


                            </div>



                        <div class="flex justify-end items-center w-1/2 justify-end">
                            <span class="mr-2 font-bold">{{ __('Search') }}</span> <!-- mr-2 font-bold -->
                            <input type="text" wire:model="search"
                                   placeholder="{{ __('Search....') }}"
                                   class="rounded-full appearance-none border border-gray-200  max-w-xl py-2 px-3 text-gray-700 leading-tight"/> <!-- input -->
                        </div><!-- flex justify-end items-center justify-end -->
                    </div>
                    @if($type)
                        <button wire:click="clear()" type="button" class="text-gray-900 bg-white border border-gray-300
                                    focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg
                                     text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600
                                     dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                            </svg>
                        </button>


                    @endif
                @endif

                <div class="flex flex-col mt-10 mb-10">


                    @if(count($products))
                        @include('livewire.catalog.products._partials.results')
                    @else
                        @include('livewire.catalog.products._partials.noresults')
                    @endif
                </div>



                @if(count($products))
                    <div class="p-4 bg-white">
                        {{$products->links()}}
                    </div>
                @endif

                @if($show_destination)
                   @include('livewire.catalog.products.destinations')
                @endif

            </div>
        </div>
    </div>
</div>
</div>
