@php
use App\Http\Controllers\cartController;
$cartobj = new cartController;
@endphp
@extends('layouts.app')
@section('content')

@include('includes.lodder')
<div class="lg:mx-14 mx-5 lg:pt-20 pt-10 pb-4 border-b">
    <h1 class="lg:text-4xl text-3xl lg:text-start text-center font-extrabold tracking-tight text-gray-900">SHOPPING CART</h1>
</div>
<div class="grid lg:grid-cols-3 grid-cols-1 lg:p-10 p-5 cart-body">
    <div class=" @if ((Auth::check() && $cart) || Auth::guest() && Session::has('guestcart') && count(Session::get('guestcart')) > 0) col-span-2 @else col-span-3 @endif guestitems">
        @if (Auth::check())
            @foreach ($cart as $item)
            <div class="grid grid-cols-4 py-10 border-b rounded-md relative" id="data{{$item->cart_id}}">
                <div class="col-span-1">
                    <img class="w-3/4 m-auto" src="{{$item->images}}" alt="">
                </div>
                <div class="lg:col-span-2 col-span-3 flex flex-col justify-between">
                    <div class="flex justify-between">
                        <div>
                            <h5 class="lg:text-lg text-sm font-medium pb-1">{{$item->product_name}}</h5>
                            <h6 class="lg:text-md text-xs text-slate-400 pb-1">{{$item->cat_name}}</h6>
                            <h6 class="lg:text-sm text-2xs font-medium pb-1">₹{{$item->our_price}}</h6>
                            
                        </div>
                        <div>
                            <input @auth onchange="updateCart(this, {{$item->cart_id}})" @endauth @if($cartobj->getStock($item->id, $item->quantity_id) == 0) @disabled(true) value='0' @class(['bg-gray-200','w-full rounded-md
                            border-slate-400']) @endif data-id={{$item->id}} class="w-full rounded-md border-slate-400
                            items" type="number" value="{{$item->items}}" name="items" min="1" max={{$cartobj->getStock($item->id, $item->quantity_id)}} id="">
                        </div>
                    </div>
                    <div>
                        <span class="lg:text-lg text-xs">{{$item->quantity}}</span>
                    </div>
                    <div class="flex">
                        {!! $cartobj->getStock($item->id, $item->quantity_id) > 0 ? "<span class='iconify text-green-400 px-1 lg:text-2xl text-base'
                            data-icon='charm:tick'></span> In Stock" : "<span class='iconify text-red-400 px-1 lg:text-2xl text-base'
                            data-icon='gridicons:cross-small'></span> <strong>Out Of Stock</strong>" !!}
                    </div>

                </div>
                <div class="lg:col-span-1 hidden text-center">
                    <button class="" onclick="cartItemDel('{{$item->cart_id}}')"><span class="iconify text-xl text-red-400"
                            data-icon="eva:close-square-outline"></span></button>
                </div>
            </div>
            @endforeach
        @else
            @if (Session::has('guestcart') && count(Session::get('guestcart')) > 0)
                @foreach (Session::get('guestcart') as $item)
                <div class="grid grid-cols-4 py-10 border-b rounded-md relative" id="data{{$item->id}}">
                    <div class="col-span-1">
                        <img class="w-3/4 m-auto" src="{{$item->images}}" alt="">
                    </div>
                    <div class="col-span-2 flex flex-col justify-between">
                        <div class="flex justify-between">
                            <div>
                                <h5 class="lg:text-lg text-sm font-medium pb-1">{{$item->product_name}}</h5>
                                <h6 class="lg:text-md text-xs text-slate-400 pb-1">{{$item->cat_name}}</h6>
                                <h6 class="lg:text-sm text-2xs font-medium pb-1">₹{{$item->our_price}}</h6>
                            </div>
                            <div>
                                <input @guest onchange="updateGuestCart(this, {{$item->id}})" @endguest @if($item->stock == 0)
                                @disabled(true) value='0' @class(['bg-gray-200','w-full rounded-md border-slate-400']) @endif
                                data-id={{$item->id}} class="w-full rounded-md border-slate-400 items" type="number"
                                value="{{$item->items}}" name="items" min="1" max={{$item->stock}} id="" >
                            </div>
                        </div>
                        <div>
                            <span>{{$item->quantity}}</span>
                        </div>
                        <div class="flex">
                            {!! $item->stock > 0 ? "<span class='iconify text-green-400 px-1 text-2xl'
                                data-icon='charm:tick'></span> In Stock" : "<span class='iconify text-red-400 px-1 text-3xl'
                                data-icon='gridicons:cross-small'></span> <strong>Out Of Stock</strong>" !!}
                        </div>

                    </div>
                    <div class="col-span-1 text-center">
                        <button class="" onclick="guestcartItemDel('{{$item->id}}')"><span class="iconify text-xl text-red-400"
                                data-icon="eva:close-square-outline"></span></button>
                    </div>
                </div>
                @endforeach
            @else
            <div class="flex justify-center items-center flex-col">
                <h5 class="text-3xl font-bold text-indigo-600 uppercase mb-5">Cart Empty</h5>
                <a href="/"><button class="p-2 bg-indigo-600 text-white rounded-md">Shop Now</button></a>
            </div>
            @endif
        @endif
    </div>
    @if ((Auth::check() && $cart && count($cart) > 0) || Auth::guest() && Session::has('guestcart') && count(Session::get('guestcart')) > 0)
    <div class="lg:col-span-1 lg:block hidden h-full relative">
        <div class="bg-slate-100 sticky top-0 w-full z-40">
            <h6 class="py-3 px-3 text-2xl font-medium">Order Summary</h6>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <tr class="">
                    <td class="py-3 px-6">Subtotal</td>
                    <th class="py-3 px-6" id="subtotal">@if(isset($subtotal)) ₹{{$subtotal}} @elseif(Session::has('guestcart')) ₹{{ $cartobj->calsubtotal() }} @endif </th>
                </tr>
                <tr class="">
                    <td class="py-3 px-6">Shipping Estimation</td>
                    <th class="py-3 px-6" id="shipping">₹50</th>
                </tr>
                <tr class="">
                    <th class="py-3 px-6">Order Total</th>
                    <th class="py-3 px-6" id="total">₹ @auth {{$subtotal + 50}} @endauth @guest {{$cartobj->calsubtotal() +  50}} @endguest</th>
                </tr>
                <tr class="">
                    <td colspan="2">
                        <form @auth action="/checkout" @endauth @guest action="/guest-checkout" @endguest method="post">
                            @csrf
                            <button class="bg-indigo-600 text-white font-medium w-full p-2">CheckOut</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @elseif(Auth::check())
        <div class="col-span-3 flex justify-center items-center flex-col">
            <h5 class="text-3xl font-bold text-indigo-600 uppercase mb-5">Cart Empty</h5>
            <a href="/"><button class="p-2 bg-indigo-600 text-white rounded-md">Shop Now</button></a>
        </div>
    @endif
</div>
@if ((Auth::check() && $cart && count($cart) > 0) || Auth::guest() && Session::has('guestcart') && count(Session::get('guestcart')) > 0)
    <div class="fixed bottom-0 p-2 bg-indigo-200 w-full lg:hidden flex justify-between items-center text-indigo-900 text-xl font-medium">
        <span id="mtotal"> ₹ @auth {{$subtotal + 50}} @endauth @guest {{$cartobj->calsubtotal() + 50}} @endguest </span>
        <form @auth action="/checkout" @endauth @guest action="/guest-checkout" @endguest method="post">
            @csrf
            <button class="text-white bg-indigo-400 font-medium w-full p-2 rounded-md">CheckOut</button>
        </form>
    </div>
@endif
@endsection
@section('bodyscript')
<script>
    $(".items").on('input',function(){
            $validate = parseInt($(this).val())
            if($(this).val() < 0)
            {
                $(this).val(0)
            }
        })
        $(".items").on('focusout',function(){
            $validate = parseInt($(this).val())
            if($(this).val() < 0 || isNaN($validate))
            {
                $(this).val(0)
            }
            
        })
</script>
@endsection