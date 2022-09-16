@extends('layouts.app')
@section('script')
<script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
@endsection
@section('content')
@include('includes.lodder')
<div class="bg-white">
    <div>
        <div id="shopfilter" class="relative z-40 lg:hidden hidden" role="dialog" aria-modal="true">

            <div class="fixed inset-0 bg-black bg-opacity-25"></div>

            <div class="fixed inset-0 flex z-40">

                <div
                    class="ml-auto relative max-w-xs w-full h-full bg-white shadow-xl py-4 pb-12 flex flex-col overflow-y-auto">
                    <div class="px-4 flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                        <button onclick="hideShopFilter()" type="button"
                            class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-gray-400">
                            <span class="sr-only">Close menu</span>
                            <!-- Heroicon name: outline/x -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Filters -->
                    <form id="mfilter" class="mt-4 border-t border-gray-200">
                        <h3 class="sr-only">Categories</h3>
                        <ul role="list" class="font-medium text-gray-900 px-2 py-3">
                            @foreach ($categories as $cat)
                            <li>
                                <a href="#" class="block px-2 py-3"> {{$cat->cat_name}} </a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-gray-200 px-4 py-6">
                            <h3 class="-mx-2 -my-3 flow-root">
                                <!-- Expand/collapse section button -->
                                <button type="button"
                                    class="px-2 py-3 bg-white w-full flex items-center justify-between text-gray-400 hover:text-gray-500"
                                    aria-controls="filter-section-mobile-0" aria-expanded="false">
                                    <span class="font-medium text-gray-900"> Availabality </span>
                                    <span class="ml-6 flex items-center">

                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <!-- Filter section, show/hide based on section state. -->
                            <div class="pt-6" id="filter-section-mobile-0">
                                <div class="space-y-6">
                                    <div class="flex items-center">
                                        <input id="filter-mobile-color-0" data-catname="in" type="checkbox"
                                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-mobile-color-0" class="ml-3 min-w-0 flex-1 text-gray-500">
                                            In Stock </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="filter-mobile-color-0" data-catname="out" type="checkbox"
                                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-mobile-color-0" class="ml-3 min-w-0 flex-1 text-gray-500">
                                            Out of Stock </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-6">
                            <h3 class="-mx-2 -my-3 flow-root">
                                <!-- Expand/collapse section button -->
                                <button type="button"
                                    class="px-2 py-3 bg-white w-full flex items-center justify-between text-gray-400 hover:text-gray-500"
                                    aria-controls="filter-section-mobile-1" aria-expanded="false">
                                    <span class="font-medium text-gray-900"> Category </span>
                                    <span class="ml-6 flex items-center">

                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <!-- Filter section, show/hide based on section state. -->
                            <div class="pt-6" id="filter-section-mobile-1">
                                <div class="space-y-6">
                                    @foreach ($categories as $cat)
                                    <div class="flex items-center">
                                        <input id="filter-mobile-category-0" data-catname="{{$cat->id}}"
                                            type="checkbox"
                                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-mobile-category-0" class="ml-3 min-w-0 flex-1 text-gray-500">
                                             {{$cat->cat_name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative z-10 flex items-baseline justify-between pt-5 lg:pt-24 pb-6 border-b border-gray-200">
                <h1 class="lg:text-4xl text-2xl font-extrabold tracking-tight text-gray-900">@if(Str::contains(URL::current(), 'shop')) PRODUCTS @elseif(isset($searchQuery)) Results For <span id="searchquery">{{$searchQuery}}</span> @else {{ count($products) > 0 ? $products[0]->cat_name : ''}} @endif </h1>

                <div class="flex items-center">
                    <div class="relative inline-block text-left">
                        <div>
                            <button type="button" data-dropdown-toggle="sort"
                                class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                Sort
                                <!-- Heroicon name: solid/chevron-down -->
                                <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div id="sort"
                            class="hidden origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1">
                                <a href="javascript:void(0)" data-hint="latest" class="text-gray-500 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                    id="menu-item-2"> Newest </a>

                                <a href="javascript:void(0)" data-hint="ASC" class="text-gray-500 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                    id="menu-item-3"> Price: Low to High </a>

                                <a href="javascript:void(0)" data-hint="DESC" class="text-gray-500 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                    id="menu-item-4"> Price: High to Low </a>
                            </div>
                        </div>
                    </div>

                    <button id="mfilterbutton" onclick="showShopFilter()" type="button" class="relative p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500 lg:hidden">
                        <span class="sr-only">Filters</span>
                        <!-- Heroicon name: solid/filter -->
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        
                    </button>
                </div>
            </div>

            <section aria-labelledby="products-heading" class="pt-6 pb-24">
                <h2 id="products-heading" class="sr-only">Products</h2>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-8 gap-y-10">
                    <!-- Filters -->
                    <form class="hidden lg:block" id="filter" method="POST">
                        <h3 class="sr-only">Categories</h3>
                        <ul role="list"
                            class="text-sm font-medium text-gray-900 space-y-4 pb-6 border-b border-gray-200">
                            @foreach ($categories as $cat)
                            <li>
                                <a href="/category/{{Str::slug($cat->cat_name)}}"> {{$cat->cat_name}} </a>
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-b border-gray-200 py-6">
                            <h3 class="-my-3 flow-root">
                                <!-- Expand/collapse section button -->
                                <button type="button"
                                    class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500"
                                    aria-controls="filter-section-0" aria-expanded="false">
                                    <span class="font-medium text-gray-900"> Availability </span>
                                    <span class="ml-6 flex items-center">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <!-- Filter section, show/hide based on section state. -->
                            <div class="pt-6" id="filter-section-0">
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="filter-color-0"  data-catname="in" type="checkbox"
                                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-color-0" class="ml-3 text-sm text-gray-600"> In Stock
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="filter-color-0" data-catname="out"  type="checkbox"
                                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-color-0" class="ml-3 text-sm text-gray-600"> Out of Stock
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 py-6">
                            <h3 class="-my-3 flow-root">
                                <!-- Expand/collapse section button -->
                                <button type="button"
                                    class="py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400 hover:text-gray-500"
                                    aria-controls="filter-section-1" aria-expanded="false">
                                    <span class="font-medium text-gray-900"> Category </span>
                                    <span class="ml-6 flex items-center">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <!-- Filter section, show/hide based on section state. -->
                            <div class="pt-6" id="filter-section-1">
                                <div class="space-y-4">
                                    @foreach ($categories as $cat)
                                    <div class="flex items-center">
                                        <input id="filter-category-0" data-catname="{{$cat->id}}"
                                            type="checkbox"
                                            class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                        <label for="filter-category-0" class="ml-3 text-sm text-gray-600">
                                            {{$cat->cat_name}} </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Product grid -->
                    <div class="lg:col-span-3">
                        <!-- Replace with your content -->
                        <div class="h-full">
                            <div id="productslist" class="border-4 grid lg:grid-cols-4 grid-cols-2 p-2 gap-2 border-solid border-[#6a74fe1f] rounded-lg lg:h-full">

                                @forelse ($products as $item)
                                <div class="border border-[#6a74fe1f] relative rounded-sm">
                                 <div class="relative">
                                     <a href="/product/{{$item->url}}">
                                        <img src="{{$item->images}}" alt="{{$item->product_name}}">
                                     </a>
                                    @if ($item->stock == 0)
                                        <div class="outofstock font-medium lg:text-xl text-xs absolute top-0 bg-[#00000082] text-[#ffffff8c] h-full w-full flex justify-center items-center">
                                            Out Of Stock
                                        </div>
                                    @endif
                                    <h5 class="lg:font-medium lg:text-base pb-2 text-xs absolute top-2 left-2 text-slate-400">{{$item->quantity}}</h5>
                                 </div>
                                 <div class="bg-slate-100 px-2">
                                    <div class="py-2">
                                        <a href="/product/{{$item->url}}">
                                            <h4 class="lg:font-medium lg:text-base pb-2 text-xs truncate">{{$item->product_name}}</h4>
                                        </a>
                                        <div class="flex justify-between">
                                            <div class="lg:block flex flex-col">
                                                <span class="line-through px-1 lg:text-sm text-xs">₹{{$item->actual_price}}</span>
                                                <span class="lg:text-base text-sm font-medium">₹{{$item->our_price}}</span>
                                            </div>
                                            @if ($item->stock > 0)
                                                <button @if(Auth::check()) onclick="addToCart(this, '{{encrypt($item->id)}}','{{encrypt(Auth::user()->id)}}')" data-helper="{{encrypt($item->quantity_id)}}" @else data-modal-toggle="authentication-modal" @endif><span class="iconify text-indigo-200 hover:text-indigo-600 lg:text-2xl text-lg" data-icon="bi:cart-plus"></span></button>
                                            @endif
                                        </div>
                                    </div>
                                 </div>
                                 @auth
                                 <button class="absolute top-2 right-2" @if(Auth::check()) onclick="addToWish('{{encrypt($item->id)}}','{{encrypt(Auth::user()->id)}}')" @else data-modal-toggle="authentication-modal" @endif>                                    
                                    <span class="iconify text-red-200 hover:font-bold lg:text-xl hover:text-red-500 text-xs" data-icon="bi:heart"></span>
                                 </button>
                                 @endauth
                        
                                </div>
                                @empty
                                
                                <div class="w-full h-full col-span-4 flex justify-center items-center">
                                    <h5 class="text-2xl font-bold uppercase text-center relative">Result Not Found!</h5>
                                </div>
                                @endforelse
     
                             </div>
                        </div>
                        <!-- /End replace -->
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

@endsection
@section('bodyscript')
    <script>
        function showShopFilter()
        {
            $("#shopfilter").removeClass('hidden')
        }
        function hideShopFilter()
        {
            $("#shopfilter").addClass('hidden')
        }
    </script>
@endsection