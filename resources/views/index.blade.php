
@extends('layouts.app')
@section('content')
@include('includes.lodder')
<div class="bg-white drop-shadow">
    <div class="p-3 max-w-[1140px] m-auto">
        <div class="lg:grid lg:grid-cols-6 md:grid-cols-6 sm:grid-cols-6 flex overflow-auto gap-3 lg:gap-10">
            <div class="flex justify-center items-center flex-col flex-row-1">
                <a href="/category/home-care"><img class="lg:w-1/2 lg:max-w-full m-auto max-w-[4.5rem] lg:p-1 px-2" src="/categories/floor-cleaner.png"></a>
                <h6 class="lg:font-bold text-xs lg:py-1 pb-3 text-center lg:uppercase capitalize">home care</h6>
            </div>
            <div class="flex justify-center items-center flex-col flex-row-1">
                <a href="/category/kitchen-care"><img class="lg:w-1/2 lg:max-w-full m-auto max-w-[4.5rem] lg:p-1 px-2" src="/categories/kitchen-care.png" alt=""></a>
                <h6 class="lg:font-bold text-xs lg:py-1 pb-3 text-center lg:uppercase capitalize">Kitchen Care</h6>
            </div>
            <div class="flex justify-center items-center flex-col flex-row-1">
                <a href="/category/body-care"><img class="lg:w-1/2 lg:max-w-full m-auto max-w-[4.5rem] lg:p-1 px-2" src="/categories/body-care.webp" alt=""></a>
                <h6 class="lg:font-bold text-xs lg:py-1 pb-3 text-center lg:uppercase capitalize">body care</h6>
            </div>
            <div class="flex justify-center items-center flex-col flex-row-1">
                <a href="/category/skin-care"><img class="lg:w-1/2 lg:max-w-full m-auto max-w-[4.5rem] lg:p-1 px-2" src="/categories/handwash.webp" alt=""></a>
                <h6 class="lg:font-bold text-xs lg:py-1 pb-3 text-center lg:uppercase capitalize">skin care</h6>
            </div>
            <div class="flex justify-center items-center flex-col flex-row-1">
                <a href="/category/hair-care"><img class="lg:w-1/2 lg:max-w-full m-auto max-w-[4.5rem] lg:p-1 px-2" src="/categories/haircare.png" alt=""></a>
                <h6 class="lg:font-bold text-xs lg:py-1 pb-3 text-center lg:uppercase capitalize">hair care</h6>
            </div>
            <div class="flex justify-center items-center flex-col flex-row-1">
                <a href="/category/baby-care"><img class="lg:w-[74px] lg:max-w-full m-auto max-w-[4.5rem] lg:p-1 px-2" src="/categories/babycare.png" alt=""></a>
                <h6 class="lg:font-bold text-xs lg:py-1 pb-3 text-center lg:uppercase capitalize">baby care</h6>
            </div>
        </div>
    </div>
</div>

<div id="default-carousel" class="relative" data-carousel="slide" data-carousel-interval="25000">
    <!-- Carousel wrapper -->
    <div class="overflow-hidden relative lg:rounded-lg h-40 lg:h-[80vh]">
        <!-- Item 1 -->
        <div class="duration-1000 ease-in-out absolute inset-0 transition-all transform translate-x-0 z-20"
            data-carousel-item="1">
            <span
                class="absolute top-1/2 left-1/2 text-2xl font-semibold text-white -translate-x-1/2 -translate-y-1/2 sm:text-3xl dark:text-gray-800">First
                Slide</span>
            <img src="/banner/dishwash-gel.webp"
                class="block absolute top-1/2 left-1/2 w-full h-full -translate-x-1/2 -translate-y-1/2" alt="...">
        </div>
        <!-- Item 2 -->
        <div class="duration-1000 ease-in-out absolute inset-0 transition-all transform translate-x-full z-10"
            data-carousel-item="2">
            <img src="/banner/multi-surface-cleaner.webp"
                class="block absolute top-1/2 left-1/2 w-full h-full -translate-x-1/2 -translate-y-1/2" alt="...">
        </div>
        <!-- Item 3 -->
        <div class="duration-1000 ease-in-out absolute inset-0 transition-all transform -translate-x-full z-10"
            data-carousel-item="3">
            <img src="/banner/floor-cleaner.webp"
                class="block absolute top-1/2 left-1/2 w-full h-full -translate-x-1/2 -translate-y-1/2" alt="...">
        </div>
        <!-- Item 4 -->
        <div class="duration-1000 ease-in-out absolute inset-0 transition-all transform -translate-x-full z-10"
            data-carousel-item="4">
            <img src="/banner/toilet-cleaner.webp"
                class="block absolute top-1/2 left-1/2 w-full h-full -translate-x-1/2 -translate-y-1/2" alt="...">
        </div>
    </div>
    <!-- Slider indicators -->
    <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
        <button type="button" class="w-3 h-3 rounded-full bg-white dark:bg-gray-800" aria-current="true"
            aria-label="Slide 1" data-carousel-slide-to="0"></button>
        <button type="button"
            class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
            aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
        <button type="button"
            class="w-3 h-3 rounded-full bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800"
            aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
    </div>
    <!-- Slider controls -->
    <button type="button"
        class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
        data-carousel-prev="">
        <span
            class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button"
        class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none"
        data-carousel-next="">
        <span
            class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>

<div class='max-w-[1140px] m-auto'>
    <h2 class='text-4xl font-bold text-center my-5 uppercase text-slate-600'><span class="product">Products</span></h2>
    <div class='grid lg:grid-cols-3 grid-cols-2'>
        @foreach ($products as $z=>$product)
        <div class="max-w-sm border bg-white dark:bg-gray-800 dark:border-gray-700 m-2 lg:p-4 border-1 show-items"
            data-hover-target='items1'>
            <div class='relative'>
                <a href="/product/{{$product->url}}">
                    <img class="lg:p-8 mb-4" src="{{$product->images}}" alt="product image">
                </a>
                <div id='items1' class='w-full'>
                    <div class='bg-gray-300 flex w-full justify-evenly items-center py-1 mb-3'>
                        <div class='hover:text-sky-500 cursor-pointer'><i @if(Auth::check()) onclick="addToWish('{{encrypt($product->id)}}','{{encrypt(Auth::user()->id)}}')" @else data-modal-toggle="authentication-modal" @endif class="fa-regular fa-heart text-xl"></i></div>
                        <div class='hover:text-sky-500 cursor-pointer'><a href="/product/{{$product->url}}"><i class="fa-regular fa-eye text-xl"></i></a></div>
                        <div class='hover:text-sky-500 cursor-pointer item'>
                            <i class="fa-solid fa-cart-plus text-xl" @if(Auth::check()) onclick="addToCart(this,'{{encrypt($product->id)}}','{{encrypt(Auth::user()->id)}}')" @else onclick="addToGuestCart(this,`{{(encrypt($product->id))}}`)" @endif id="cart{{$product->id}}" data-helper='{{encrypt(\App\Models\Stock::select('stocks.quantity_id')->join('quantities','quantities.id','stocks.quantity_id')->join('products','stocks.product_id','products.id')->where('stocks.product_id',$product->id)->get()->first()->quantity_id)}}'></i>
                        </div>
                        <!--<div class='hover:text-sky-500 cursor-pointer'>-->
                        <!--    <i class="fa-solid fa-arrow-right-arrow-left text-xl"></i>-->
                        <!--</div>-->
                    </div>
                </div>
                <div class="lg:p-0 p-2 my-2">
                    <span class='lg:pb-5 text-gray-400 font-bold'>{{$product->cat_name}}</span>
                    <div>
                        <a href="#">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{$product->product_name}}
                            </h5>
                        </a>
                        <!--<span class='text-gray-800 font-bold'>₹{{$product->our_price}}</span>-->
                    </div>
                </div>
                <div id="quantity{{$product->id}}" class="pb-3 lg:p-0 px-2 flex items-center gap-1 flex-wrap">
                    @foreach (\App\Models\Stock::select('stocks.our_price','stocks.stock','stocks.quantity_id','products.id','quantities.quantity')->join('quantities','quantities.id','stocks.quantity_id')->join('products','stocks.product_id','products.id')->where('stocks.product_id',$product->id)->get() as $i=>$st)
                        <button @if($st->stock == 0) class='border rounded-md bg-slate-100 cursor-not-allowed p-2 text-slate-500' @else data-help="{{$product->id}}" data-q='{{encrypt($st->quantity_id)}}' onclick="changeQuantity(this)" class="border @if($i==0) border-indigo-600 text-indigo-400 font-bold @endif lg:py-2 p-1 lg:px-3  rounded-md" @endif ><pre class="lg:text-base text-sm">{{$st->quantity}}</pre> <span class="lg:text-xs text-2xs flex">₹{{$st->our_price}}</span></button>
                    @endforeach
                </div>
            </div>
            

        </div>
        @endforeach
    </div>
</div>
@endsection
