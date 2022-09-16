@extends('layouts.app')
@section('content')
     
<div class="lg:p-12 p-5">
    <!-- Desktop Responsive Start -->
    <div class="hidden sm:flex flex-col justify-start items-start">
        <div class="pl-4 lg:px-10 2xl:px-20 flex flex-row justify-center items-end space-x-4">
            <h1 class="text-4xl font-semibold leading-9 text-gray-800  dark:text-white">Favourites</h1>
            <p class="text-base leading-4 text-gray-600 dark:text-white pb-1">({{count($wishlists)}} Items)</p>
        </div>
        <table class="w-full mt-16 whitespace-nowrap">
            <thead aria-label="table heading" class="w-full h-16 text-left py-6 bg-gray-50 border-gray-200 dark:bg-gray-800 border-b">
                <tr>
                    <th class="text-base font-medium leading-4 text-gray-600 dark:text-white 2xl:pl-20 pl-4 lg:pl-10">YOUR PRODUCT</th>
                    <th class="text-base font-medium leading-4 text-gray-600 dark:text-white pl-6 lg:pl-20 2xl:pl-52">DESCRIPTION</th>
                    <th class="text-base font-medium leading-4 text-gray-600 dark:text-white pl-6 lg:pl-20 2xl:pl-52">PRICE</th>
                    <th class="text-base font-medium leading-4 text-gray-600 dark:text-white pl-6 lg:pl-20 2xl:pl-52">MORE OPTIONS</th>
                    <th class="text-base font-medium leading-4 text-gray-600 dark:text-white 2xl:pl-28 2xl:pr-20 pr-4 lg:pr-10"></th>
                </tr>
            </thead>
            <tbody class="w-full text-left">
              @foreach ($wishlists as $wishlist)
              <tr class="border-gray-200 border-b">
                <th><img class="my-10 pl-4 lg:pl-10 2xl:pl-20 w-52" src="{{$wishlist->images}}" alt="{{$wishlist->product_name}}" /></th>
                <th class="mt-10 text-base font-medium leading-4 text-gray-600 pl-6 lg:pl-20 2xl:pl-52">
                    <p class="text-base leading-4 text-gray-800 dark:text-white">{{$wishlist->product_name}}</p>
                </th>
                <th class="my-10 pl-6 lg:pl-20 2xl:pl-52">
                    <span class="line-through px-1 font-normal">₹{{$wishlist->actual_price}}</span>
                    <span class="dark:text-white text-2xl">₹{{$wishlist->our_price}}</span>
                </th>
                <th class="my-10 text-base font-medium leading-4 text-gray-600 pl-6 lg:pl-20 2xl:pl-52">
                    <a href="/product/{{$wishlist->url}}" class="hover:underline text-base font-medium leading-none text-gray-800 dark:text-white focus:outline-none focus:underline">View details</a>
                </th>
                <th class="my-10 pl-4 lg:pl-12 2xl:pl-28 pr-4 2xl:pr-20">
                    <a href="/wishdelete/{{encrypt($wishlist->wish_id)}}">
                        <button class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800 text-base leading-none text-red-600 hover:text-red-800"><p>Remove Item</p></button>
                    </a>
                </th>
            </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    <!-- Desktop Responsive End -->

    <!-- Mobile Responsive Start -->
    <div class="flex justify-center items-center">
        <div class="sm:hidden flex flex-col justify-start items-start">
            <div class="px-4 lg:px-10 2xl:px-20 flex flex-row justify-start items-end space-x-4">
                <p class="text-4xl font-semibold leading-9 text-gray-800 dark:text-white">Favourites</p>
                <p class="text-base leading-4 text-gray-600 pb-1">(12 Items)</p>
            </div>
            @foreach ($wishlists as $wishlist)
            <div class="border-gray-200 border-b pb-10">
                <div class="px-4 flex flex-col jusitfy-center items-start mt-10">
                    <div>
                        <img src="{{$wishlist->images}}" alt="{{$wishlist->product_name}}" />
                    </div>
                </div>
                <div class="px-4 mt-6 flex justify-between w-full flex jusitfy-center items-center">
                    <div>
                        <p class="w-36 text-base leading-6 text-gray-800 dark:text-white">{{$wishlist->product_name}}</p>
                    </div>
                    <div>
                        <span class="line-through px-1 font-normal">₹{{$wishlist->actual_price}}</span>
                        <span class="dark:text-white text-2xl">₹{{$wishlist->our_price}}</span>
                    </div>
                </div>
                <div class="px-4 mt-6 flex justify-between w-full flex jusitfy-center items-center">
                    <div>
                        <a href="/product/{{$wishlist->url}}" class="hover:underline text-base font-medium leading-none focus:outline-none focus:underline text-gray-800 dark:text-white"> View details</a>
                    </div>
                    <div>
                        <a href="/wishdelete/{{encrypt($wishlist->wish_id)}}">
                            <button class="focus:outline-none focus:ring-red-800 focus:ring-offset-2 focus:ring-2 text-base leading-none text-red-600 hover:text-red-800"><p>Remove Item</p></button>
                        </a> 
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Mobile Responsive End -->
</div>

@endsection