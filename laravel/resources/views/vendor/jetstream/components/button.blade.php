<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-ezysoft align-middle select-none font-sans font-bold text-center
                                    uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none
                                    text-xs py-2 px-3 rounded-lg bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-md
                                    shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 active:opacity-[0.85] flex items-center gap-3']) }}>
    {{ $slot }}
</button>
