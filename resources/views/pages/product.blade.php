@extends('layouts.app')
@section('content')
@include('includes.lodder')

<div class="flex items-center py-4 overflow-y-auto whitespace-nowrap px-4">
    <a href="#" class="text-gray-600 dark:text-gray-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
        <path
          d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
      </svg>
    </a>

    <span class="mx-1 text-gray-500 dark:text-gray-300">
      /
    </span>

    <a href="#" class="text-gray-600 dark:text-gray-200 hover:underline">
      Shop
    </a>

    <span class="mx-1 text-gray-500 dark:text-gray-300">
      /
    </span>

    <a href="#" class="text-gray-600 dark:text-gray-200 hover:underline">
      Product
    </a>

    <span class="mx-1 text-gray-500 dark:text-gray-300">
      /
    </span>

    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">
      Details
    </a>
  </div>
  <div class="grid lg:grid-cols-12 grid-cols-1 w-100 px-5 py-3">
    <div class="col-span-7 flex flex-col justify-center items-center">
      <img id="preview" width="400"
        src="{{$product->images}}" alt="no image">
    </div>
    <div class="col-span-5 flex pt-5 flex-col">
      <h1 class="p-2">Product Name: {{$product->product_name}}</h1>
      <h4 class="p-2">Price ₹{{$product->our_price}}</h4>
      <h5 class="p-2">Product Type: {{$product->cat_name}}</h5>
      <p class="p-2">{{$product->short_description}}</p>
      <div class="d-flex flex-column p-2">
        <label for="net" class="py-2">Choose Quantity: </label>
        <div class="d-flex">
          <select class="w-25 p-2 border outline-0" name="quantity" id="quantity">
            @foreach ($quantities as $quantity)
                <option value="{{encrypt($quantity->id)}}">{{$quantity->quantity}}</option>
            @endforeach
          </select>
          <input id='item' class="form-control w-25 text-center mx-3" type="number" name="number" min="1" max="{{$product->stock}}" value="1">
        </div>
        @if ($product->stock > 0)
          @if ($product->stock < 10)
              <h6 class="text-sm font-medium text-red-400 mt-3 ms-2">Only {{$product->stock}} Left Harry Up...</h6>
          @endif
        <button @if(Auth::check()) onclick="addToCart(this, '{{encrypt($product->id)}}','{{encrypt(Auth::user()->id)}}')" @else data-modal-toggle="authentication-modal" @endif class="p-2 rounded-md text-white bg-black w-50 mt-3 ms-2">Add Cart</button>
        @else
            <button type="button" class="p-2 rounded-md text-white font-medium bg-gray-400 w-50 mt-3 ms-2">Out Of Stock</button>
        @endif
      </div>
    </div>
  </div>

    <div class='mx-5 my-20' id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
      <h2 id="accordion-color-heading-1">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border border-b-0 border-gray-200 rounded-t-sm focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 hover:bg-blue-100 dark:hover:bg-gray-800 bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white" data-accordion-target="#accordion-color-body-1" aria-expanded="true" aria-controls="accordion-color-body-1">
          <span>Description</span>
          <svg data-accordion-icon="" class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-color-body-1" class="" aria-labelledby="accordion-color-heading-1">
        <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
          <p class="mb-2 text-gray-500 dark:text-gray-400">{{$product->description}}</p>
        </div>
      </div>
      
      <h2 id="accordion-color-heading-2">
        <button type="button" class="flex items-center justify-between w-full p-5 rounded-b-sm font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-2" aria-expanded="false" aria-controls="accordion-color-body-2">
          <span>Direction</span>
          <svg data-accordion-icon="" class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
        <div class="p-5 font-light border border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">{{$product->direction}}</p>
        </div>
      </div>
    </div>
  <hr class="bg-gray-600">
  <div class="my-20">
    @include('includes.newproduct')
  </div>
  <hr class="bg-gray-600">
  <div class="my-20">
    @include('includes.popular')
  </div>

@endsection