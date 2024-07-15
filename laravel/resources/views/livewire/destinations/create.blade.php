

<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all
        sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full" role="dialog" aria-modal="true"
             aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                    <style>

                        .toggle-checkbox:checked {
                            @apply: right-0 border-green-400;
                            right: 0;
                            border-color: #68D391;
                        }
                        .toggle-checkbox:checked + .toggle-label {
                            @apply: bg-green-400;
                            background-color: #68D391;
                        }
                    </style>

                    <div class="mt-10">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mt-5">

                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="active"
                                           class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                                     dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Active') }}</span>
                                </label>



                            </div>
                            <div class="mb-4">
                                <label for="name" class="block
                                text-gray-700 text-sm font-bold mb-2">{{ __('Store name') }}
                                    <span class="text-red-700">*</span>
                                </label>

                                <input type="text" class="rounded-full appearance-none
                                  border border-gray-200 w-full py-2 px-3 text-gray-700 leading-tight "
                                       id="name" placeholder="{{ __('Store name') }}"
                                       wire:model="name"
                                >
                                @error('name')
                                    <span class="text-red-500 text-xs font-medium">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                        </div>

                        <div class="grid grid-cols-1 gap-4">
                        <div class="mb-4">
                            <label for="callback_url"
                                   class="block text-gray-700 text-sm font-bold mb-2">{{ __('Connection url') }}


                                <span class="text-red-700">*</span>
                            </label>

                            <input type="text" class="rounded-full appearance-none border border-gray-200
                                 w-full py-2 px-3 text-gray-700 leading-tight "
                                   id="sku" placeholder="{{ __('Connection url') }}"
                                   wire:model="destination_url_conn">
                            <div class="flex flex-col">
                                @error('destination_url_conn')
                                <span class="text-red-500 text-xs font-medium">
                                     {{ $message }}
                                    </span>
                                @enderror
                                <span class="text-xs mt-1 mt-3	 flex justify-start items-center font-normal gap-1	">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
</svg>

                             {{__('You will need to install the plugin on your online store')}}
                                </span>
                            </div>




                        </div>
                    </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="mb-4">
                                <label for="callback_url"
                                       class="block text-gray-700 text-sm font-bold mb-2">{{ __('Webhook') }}


                                    <span class="text-red-700">*</span>
                                </label>

                                <input type="text" class="rounded-full appearance-none border border-gray-200
                                 w-full py-2 px-3 text-gray-700 leading-tight "
                                       id="sku" placeholder="{{ __('Webhook') }}"
                                       wire:model="destination_url">

                                <div class="flex flex-col">
                                    @error('destination_url')
                                    <span class="text-red-500 text-xs font-medium">
                                     {{ $message }}
                                    </span>
                                    @enderror
                                    <span class="text-xs mt-1 mt-3	 flex justify-start items-center font-normal gap-1	">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
</svg>

                             {{__('You will need to install the plugin on your online store')}}
                                </span>
                                </div>

                            </div>


                        </div>
                    </div>



                </div>


                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex justify-center sm:flex-row-reverse">
                       <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">



                               <button wire:click.prevent="store()" type="button" class="btn-ezysoft align-middle select-none font-sans font-bold text-center
                           uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none
                           text-xs py-4 px-10 rounded-lg bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-md
                           shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 active:opacity-[0.85] flex items-center gap-3">

                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                  stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round"
                       d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
               </svg>

                                   <span class="ml-2">
                                          {{ __('Create') }}
                                   </span>

                         </button>








                       </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                         <button wire:click="close()" type="button"
                                 class="inline-flex justify-center items-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">

                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                  fill="currentColor">
                 <path fill-rule="evenodd"
                       d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                       clip-rule="evenodd"/>
               </svg>
                               <span class="ml-2">
                                     {{ __('Cancel') }}
                               </span>
                         </button>
                       </span>
                </div>

            </form>


        </div>

    </div>
</div>

