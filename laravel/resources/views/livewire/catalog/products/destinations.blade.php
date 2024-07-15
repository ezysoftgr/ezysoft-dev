

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
                <div class="px-4 py-3 header-form text-center flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         class="h-5 w-5 fill-white stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                    </svg>



                    <h1 class="text-center text-white text-2xl ml-2">   {{ __('Please select store') }}</h1>
                </div>



                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">





                        <div class="grid space-y-5">










                            <form  wire:submit="create">
                                <dl class=" text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            @foreach($destinations as  $destination)

                                @if($destination->active)

                                            <div class="destination pt-3 pb-3 flex items-center justify-between gap-3 w-full">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" wire:model="selectedItems" value="{{$destination->id}}"
                                                           class="sr-only peer">
                                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300
                                     dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{$destination->name}}</span>


                                                </label>
                                                <div class="type">

                                                </div>

                                                <div class="message-response flex items-center gap-1">
                                                    @if($messages)
                                                        @if(isset($messages[$destination->id]))
                                                            @if($messages[$destination->id]['status'])
                                                                <div>
                                                          <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" stroke-width="1.5" stroke="currentColor"
                                                                            class="flex-shrink-0 size-3">
                                                                  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                                </svg>

                                                                        {{$messages[$destination->id]['message']}}
                                                                      </span>
                                                                </div>

                                                            @else
                                                                <div>
                                                                  <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                                                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                      <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                                                      <path d="M12 9v4"></path>
                                                                      <path d="M12 17h.01"></path>
                                                                    </svg>
                                                                        {{$messages[$destination->id]['message']}}
                                                                  </span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>


                                            </div>
                                        @else
                                            <div class="flex justify-center items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                <span class="font-light py-8  text-xl		 ml-2">{{__("Not found destinations")}}</span>
                                            </div>

                                        @endif




                            @endforeach
                                </dl>
                                @error('selectedItems') <span class="text-red-500 text-xs font-medium">{{ $message }}</span>@enderror



                            </form>

                        </div>
                    </div>






                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex justify-center sm:flex-row-reverse">
                       <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">



                               <button wire:click.prevent="store()" type="button" class="align-middle btn-ezysoft select-none font-sans font-bold text-center
                           uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none
                           text-xs py-4 px-10 rounded-lg bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-md
                           shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 active:opacity-[0.85] flex items-center gap-3">

                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                  stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round"
                       d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
               </svg>

                           {{ __('Go') }}

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

