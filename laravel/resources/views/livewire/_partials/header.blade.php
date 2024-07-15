

<header class="bg-white ">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
<h2 class="font-semibold text-xl flex flex-col text-gray-800 leading-tight">
    <div class="flex justify-between  items-center gap-4">

        <div class="left flex gap-4">
            {!! $icon !!}
            <div class="flex-col">
                      <span>
                     {{ $title }}
                 </span><!-- span-->
                <small class="font-light text-gray-400">
                    {{ $description }}
                </small><!-- font-light text-gray-400 -->
            </div>
        </div><!-- left flex flex-col -->

        <div class="right flex gap-4 items-center">
            @if(!empty($add_new))
                <button wire:click="create()
                                " type="button" class="  btn-ezysoft align-middle select-none font-sans font-bold text-center
                                    uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none
                                    text-xs py-2 px-3 rounded-lg bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-md
                                    shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 active:opacity-[0.85] flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    {{ $add_new }}
                </button>
            @endif
        </div>

    </div><!-- flex  items-center gap-4 -->
</h2><!-- font-semibold text-xl flex flex-col text-gray-800 leading-tight-->



        </div>
    </header>
