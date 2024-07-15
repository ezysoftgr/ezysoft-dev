<div>
    @include('livewire._partials.header', [
           'title' => __('Customers'),
           'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
</svg>',
           'description' => __('List of customers')
       ])



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden  sm:rounded-lg">
                <div class="p-6  bg-white  border-gray-200">

                    @if($count)

                        <div class="flex justify-end items-center justify-end">
                            <span class="mr-2 font-bold">{{ __('Search') }}</span> <!-- mr-2 font-bold -->
                            <input type="text" wire:model="search" placeholder="{{ __('Search....') }}"
                                   class="rounded-full appearance-none border border-gray-200  max-w-xl py-2 px-3 text-gray-700 leading-tight"/> <!-- input -->
                        </div><!-- flex justify-end items-center justify-end -->



                    @endif



                    <div class="flex flex-col mt-10 mb-10">
                        @if(count($customers))
                            @include('livewire.customers._partials.results')
                        @else
                            @include('livewire.customers._partials.noresults')
                        @endif
                    </div>

                    @if(count($customers))
                        <div class="p-4 bg-white">
                            {{$customers->links()}}
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>


</div>
