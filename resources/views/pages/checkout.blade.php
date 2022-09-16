@php
use App\Http\Controllers\cartController;
$cartobj = new cartController;
@endphp
@extends('layouts.app')
@section('content')
<div class="main lg:h-screen lg:m-0 mb-10">
    <div class="grid lg:grid-cols-3 grid-cols-1 h-full">
        <div class="w-full col-span-2 lg:p-20 p-3 h-96 lg:full overflow-auto relative">
            <h1 class="text-3xl border-b lg:p-0 p-3 font-bold uppercase">Checkout</h1>
            @auth
            <div id="addresses" class="h-4/6 overflow-auto">
                @foreach ($addresses as $address)
                <div class="border p-3 rounded-md">
                    <div class="flex items-center">
                        <input @if($address->selected == 1) @checked(true) @endif onclick="updateAddress(this)"
                        type="radio" class="px-2" name="address_id" value="{{encrypt($address->id)}}">
                        <span class="px-2 font-medium">{{$address->name}}</span>
                        <span class="px-2 font-medium">{{$address->phone}}</span>
                    </div>
                    <p>{{$address->address.", ".$address->landmark.", ".$address->city.", ".$address->state.",
                        ".$address->country.", ".$address->zipcode}}</p>
                </div>
                @endforeach
            </div>
            <div class="lg:text-end">
                <div class="bg-indigo-500 rounded-md text-white p-2 my-2 text-start"><span class="cursor-pointer"
                        data-modal-toggle="addaddress-model">Add New Address<span></div>
                <form class="lg:block hidden" action="/payment" method="post">
                    @csrf
                    <button class="bg-indigo-600 rounded-md text-white p-2 my-2 capitalize">Proceed to payment</button>
                </form>
                <form class="fixed bottom-0 left-0 w-full lg:hidden text-indigo-900 text-xl font-medium" action="/payment" method="post">
                    @csrf
                    <button class="text-white bg-indigo-500 font-medium w-full p-2 capitalize">Proceed to payment</button>
                </form>

            </div>
            @endauth

            @auth
            <div id="addaddress-model" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-max h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="addaddress-model">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white uppercase font-bold">Add
                                new address
                            </h3>
                            @include('includes.addaddress')
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            @guest
                @include('includes.addaddress')
            @endguest
        </div>
        <div class="lg:p-10 p-2 bg-indigo-50">
            <div class="py-3 overflow-auto px-2 h-[50vh]">
                @auth
                @foreach ($cart->where('stocks.stock','>',0)->get() as $item)
                <div class="flex justify-between gap-3 my-2 py-2 border-b border-indigo-100">
                    <div class="flex gap-4">
                        <img class="w-16 border rounded-md" src="{{$item->images}}" alt="{{$item->product_name}}">
                        <h6 class="text-wrap font-medium">{{$item->product_name}}</h6>
                    </div>
                    <div>
                        {{$item->items}} x ₹{{$item->our_price}}
                    </div>
                </div>
                @endforeach
                @endauth
                @guest
                @foreach (Session::get('guestcart') as $item)
                @if ($item->stock > 0)
                <div class="flex justify-between gap-3 my-2 py-2 border-b border-indigo-100">
                    <div class="flex gap-4">
                        <img class="w-16 border rounded-md" src="{{$item->images}}" alt="{{$item->product_name}}">
                        <h6 class="text-wrap font-medium">{{$item->product_name}}</h6>
                    </div>
                    <div>
                        {{$item->items}} x ₹{{$item->our_price}}
                    </div>
                </div>
                @endif
                @endforeach
                @endguest
            </div>
            <div class="flex justify-between py-3 border-t border-indigo-200 lg:px-0 px-2">
                <span>Subtotal:</span> <span>@if(isset($subtotal)) ₹{{$subtotal}} @elseif(Session::has('guestcart')) ₹{{
                    $cartobj->calsubtotal() }} @endif</span>
            </div>
            <div class="flex justify-between py-3 border-b border-indigo-200 lg:px-0 px-2">
                <span>Shipping:</span> <span>₹50</span>
            </div>
            <div class="flex justify-between py-3 lg:px-0 px-2">
                <span>Total:</span> <span class="text-xl font-bold"><span class="text-xs">INR</span>
                    ₹{{$cartobj->calsubtotal() + 50}}</span>
            </div>
        </div>
    </div>
</div>
@endsection
@section('bodyscript')
<script>
    function updateAddress(ele)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'patch',
                data: {id: ele.value},
                url: '/update-address'
            })
        }
        $("[data-toggle]").click(function(){
            $($(this).attr('data-toggle')).removeClass('hidden');
        })
</script>
@endsection