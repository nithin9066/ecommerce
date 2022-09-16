<div id='' class="bg-[#0112fe8c] py-1">
    {{-- desktop --}}
    <div class="hidden lg:grid grid-cols-12 text-white px-2">
        <div class="col-span-2">
            <div class="flex justify-end items-center h-full">
                <a href="/" class="w-3/4 lg:mr-5"><img src="/logo.png" alt=""></a>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <button id="dropdownDividerButton2" data-dropdown-toggle="lang"
                class="text-white lg:mr-5 flex justify-center items-center font-bold" type="button"><img class="w-6"
                    src="/icons/india.svg"> <svg class="ml-2 w-4 h-4" aria-hidden="true" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg></button>
            <!-- Dropdown menu -->
            <div id="lang"
                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                data-popper-placement="bottom"
                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(255.556px, 65.5556px);">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton">
                    <li>
                        <a href="#"
                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">English</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Hindi</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-span-5">
            <form class="flex justify-center items-stretch" action="/search" method="POST">
                @csrf
                <input class="outline-0 border-0 h-4/5 bg-white w-full px-2 rounded-l-lg font-medium text-gray-500"
                    type="search" name="q" placeholder="Search for Products">
                <button class="bg-yellow-400 px-3 h-auto rounded-r-lg text-gray-400"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="col-span-3 flex justify-center items-center text-white">
            <div class="flex justify-between items-center w-4/6">
                <button class="bg-white text-[#747dfe] px-2 py-1 font-bold text-sm rounded-md">Orders</button>
                <div class="flex flex-row">
                    <a class="cursor-pointer" @if(Auth::check()) href="/wishlist" @else data-modal-toggle="authentication-modal" @endif>
                        <span class="iconify text-2xl" data-icon="bi:bag-heart"></span>
                    </a>
                    <span class="px-1 font-normal text-md" id="wishcount">{{isset($wishcount) ? $wishcount : 0}}</span>
                </div>
                <div class="flex text-white">
                    <a class="cursor-pointer" @if(Auth::check()) href="/cart" @else href="/cart" @endif>
                        <span class="iconify text-2xl" data-icon="bi:cart"></span>
                    </a>
                    <span class='px-1 font-normal text-md' id="cartcount">{{ Auth::check() ? $cartobj->getcartcount() : (Session::has('guestcart') ? $cartobj->getGuestItemsCount() : 0) }}</span>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center text-[#747dfe]">
            <div class="w-full text-white">
              @if(Auth::check())
                @include('includes.profile')
              @else
              <button class="bg-white px-3 py-1 font-bold text-sm rounded-md text-[#747dfe]" data-modal-toggle="authentication-modal">SignIn</button>
              @endif
            </div>
        </div>
        <div></div>
    </div>
    {{-- mobile --}}
    <div class="grid grid-cols-2 lg:hidden">
        <div class="flex justify-center items-center">
            <img class="w-full" src="/logo.png" alt="apsensyscare">
        </div>
        <div class="text-white flex lg:justify-center justify-end items-center gap-2 pr-1">
            <div class="flex flex-row justify-center items-center">
                <a class="cursor-pointer" @if(Auth::check()) href="/wishlist" @else data-modal-toggle="authentication-modal" @endif>
                    <span class="iconify lg:text-xl text-lg" data-icon="bi:bag-heart"></span>
                </a>
                <span class="px-1 font-normal text-md" id="mwishcount">{{isset($wishcount) ? $wishcount : 0}}</span>
            </div>
            <div class="flex text-white justify-center items-center">
                <a class="cursor-pointer" @if(Auth::check()) href="/cart" @else href="/cart" @endif>
                    <span class="iconify lg:text-xl text-lg" data-icon="bi:cart"></span>
                </a>
                <span class='px-1 font-normal text-md' id="mcartcount">{{ Auth::check() ? $cartobj->getcartcount() : (Session::has('guestcart') ? $cartobj->getGuestItemsCount() : 0) }}</span>
            </div>
        </div>
    </div>
    <div class="mx-2 mb-1 mt-3 lg:hidden">
        <form class="flex justify-center items-stretch" action="/search" method="POST">
            @csrf
            <input class="outline-0 border-0 p-1 px-2 bg-whitepx-2 w-full rounded-l-md font-medium text-gray-500"
                type="search" name="q" placeholder="Search for Products">
            <button class="bg-yellow-400 px-3 rounded-r-md text-gray-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>
    @if (!in_array($currentRoute, $secure))
        <div class="before:content-[''] before:w-[30vw] before:h-1.5 before:rounded-t-md before:bg-indigo-600 before:absolute before:-top-1 before:translate-x-[35vw]  lg:hidden fixed bottom-0 bg-indigo-50 z-50 w-full p-2 grid grid-cols-3 pt-5 rounded-t-3xl shadow">
            <button id="dropdownDividerButton3" data-dropdown-toggle="mlang" class="lg:mr-5 flex justify-center items-center font-bold" type="button"><img class="w-7" src="/icons/india.svg"> <svg class="ml-2 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg></button>
            <div id="mlang" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 block" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(190px, 46px);" data-popper-placement="bottom">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDividerButton3">
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">English</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Hindi</a>
                    </li>
                </ul>
            </div>
            <a href="myorders" class="shadow-2xl shadow-indigo-900 bg-indigo-200 rounded-3xl text-indigo-600 font-semibold"><button class="p-2 w-full">Orders</button></a>
            <div class="flex justify-center items-center text-[#747dfe]">
                <div class="text-white">
                @if(Auth::check())
                    @include('includes.mprofile')
                @else
                <button class="px-3 py-1 font-medium text-sm rounded-md text-white" data-modal-toggle="authentication-modal">SignIn</button>
                @endif
                </div>
            </div>
        </div>
    @endif
</div>