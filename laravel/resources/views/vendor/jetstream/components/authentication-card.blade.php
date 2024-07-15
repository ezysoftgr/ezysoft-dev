<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white auth-padding overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    <div class="mt-3"> <small>
            ezySoft. Ένα προϊόν της <a href="https://nextpointer.gr">Nextpointer.gr</a>
        </small> </div>
</div>
