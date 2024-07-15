<div>

@include('livewire._partials.header', [
           'title' => __('Orders'),
           'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
</svg>',
            'description' => __('List of orders'),

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
                        @if(count($orders))
                            @include('livewire.orders._partials.results')
                        @else
                            @include('livewire.orders._partials.noresults')
                        @endif
                    </div>

                    @if(count($orders))
                        <div class="p-4 bg-white">
                            {{$orders->links()}}
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

</div>
