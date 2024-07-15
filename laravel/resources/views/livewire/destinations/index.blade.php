<div>
    @include('livewire._partials.header', [
               'title' => __('Destinations'),
               'icon'  =>  '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
</svg>',
                'description' => __('List of destinations'),
                'add_new' => __('Add new Destination')
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
                        @if(count($destinations))
                            @include('livewire.destinations._partials.results')
                        @else
                            @include('livewire.destinations._partials.noresults')
                        @endif
                    </div>

                    @if(count($destinations))
                        <div class="p-4 bg-white">
                            {{$destinations->links()}}
                        </div>
                    @endif

                    @if($open)
                        @include('livewire.destinations.create')
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
