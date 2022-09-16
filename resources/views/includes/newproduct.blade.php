<div class="bg-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">NEW PRODUCTS</h2>

      <div class="mt-6 grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        @foreach ($newproduct as $new)
        <div class="group relative border p-2 rounded-md">
          <div
            class="w-full relative min-h-80 flex align-items-center bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
            <img src="{{$new->images}}"
              alt="Front of men&#039;s Basic Tee in black."
              class="w-full h-full object-center object-cover lg:w-full lg:h-full">
              @if ($new->stock == 0)
                  <div class="outofstock font-medium text-xl absolute top-0 bg-[#00000082] text-[#ffffff8c] h-full w-full flex justify-center items-center">
                      Out Of Stock
                  </div>
              @endif
          </div>
          <div class="mt-4 flex justify-between">
            <div>
              <h3 class="text-sm text-gray-700">
                <a href="/product/{{$new->url}}">
                  <span aria-hidden="true" class="absolute inset-0"></span>
                  {{$new->product_name}}
                </a>
              </h3>
              <p class="mt-1 text-sm text-gray-500">{{$new->cat_name}}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">₹{{$new->our_price}}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>