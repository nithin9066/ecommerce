@extends('layouts.app')
@section('content')
@include('includes.lodder')
<div class="h-screen">
    <div class="grid lg:grid-cols-12 grid-cols-1 h-full">
        <div class="col-span-3 lg:block hidden border-r border-indigo-100 bg-indigo-600">
            <div class="my-3 px-4 text-xl text-white rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <input class="border border-indigo-300 shadow-xl rounded-lg w-full mb-2 text-indigo-200 font-medium bg-indigo-500" type="search" name="key" id="search" placeholder="Order Id . . .">
                <button onclick="orderFilter(this,-1)" type="button" class="orderfilter border-white uppercase text-start py-2 w-full px-4 cursor-pointer hover:bg-gray-100 hover:text-blue-700">
                    All
                </button>
                <button onclick="orderFilter(this,1)" type="button" class="orderfilter border-white uppercase text-start py-2 w-full px-4 cursor-pointer hover:bg-gray-100 hover:text-blue-700">
                    Received
                </button>
                <button onclick="orderFilter(this,2)" type="button" class="orderfilter border-white uppercase text-start py-2 w-full px-4 cursor-pointer hover:bg-gray-100 hover:text-blue-700">
                    Cancelled
                </button>
                <button onclick="orderFilter(this,3)" type="button" class="orderfilter border-white uppercase text-start py-2 w-full px-4 cursor-pointer hover:bg-gray-100 hover:text-blue-700">
                    Refunded
                </button>
                <button onclick="orderFilter(this,0)" type="button" class="orderfilter border-white uppercase text-start py-2 w-full px-4 cursor-pointer hover:bg-gray-100 hover:text-blue-700">
                    Transit
                </button>
            </div>
        </div>
        <div class="lg:col-span-9 overflow-hidden pb-32 uppercase">
            <div class="flex justify-between p-4 border-b border-indigo-100">
                <h1 class="lg:text-5xl text-3xl font-extrabold">My Orders</h1>
                <button type="button" id="morderfilter" class="lg:hidden font-medium inline-flex relative items-center p-3">
                    Filter <div class="inline-flex absolute -top-2 -right-2 justify-center items-center w-6 h-6 text-xs font-bold text-white bg-indigo-500 rounded-full border-2 border-white dark:border-gray-900 hidden"></div>
                  </button>
            </div>
            <div id="myorders" class="grid lg:grid-cols-3 grid-cols-1 p-4 gap-4 overflow-auto h-full">
             @foreach ($myOrders as $order)
             <div class="p-4 border border-indigo-100 rounded-md h-fit">
                <div class="flex justify-between">
                    <div>
                        <p class="font-bold">#{{$order->order_id}}</p>
                        <p class="font-semibold text-indigo-300 text-xs px-1">{{\Carbon\Carbon::parse($order->created_at)->format('d-m-Y | h:i:s A')}}</p>
                    </div>
                    <div class="rounded-full w-10 h-10 bg-indigo-200 font-bold text-indigo-500 flex justify-center items-center text-xs">₹{{round($order->total)}}</div>
                </div>
                <div class="my-5 font-medium text-sm text-gray-500 h-28 overflow-auto">
                    @foreach ($order->products as $product)
                    <div class="flex justify-between items-center my-2">
                        <div>
                            <a href="">{{$product->product_name}}</a> <span class="text-xs">x {{$product->items}}</span>
                        </div>
                        <img class="w-10" src="{{$product->images}}" alt="{{$product->product_name}}">
                    </div>
                    @endforeach
                </div>
                <div id='status{{$order->id}}' class="border-t-2 {{$order->order_status == "cancelled" ? 'border-red-200' : ($order->order_status == "refunded" ? 'border-yellow-200' : ($order->order_status == "delivered" ? 'border-green-200' : 'border-indigo-300'))}} p-2 gap-4 flex justify-between items-center">
                    @if ($order->order_status == "cancelled")
                    <button class="w-full bg-red-200 text-red-600 text-xs font-bold uppercase p-2 rounded-md">Cancelled</button>
                    @elseif ($order->order_status == "refunded")
                    <button class="w-full bg-yellow-200 text-yellow-600 text-xs font-bold uppercase p-2 rounded-md">Refunded</button>
                    @elseif ($order->order_status == "delivered")
                    <a href="/generate-invoice/{{encrypt($order->order_id)}}"><button class="w-full text-xs font-bold p-2 uppercase text-white bg-indigo-500 rounded-md">Invoice</button></a>
                    <button class="w-full bg-green-200 text-green-600 text-xs font-bold uppercase p-2 rounded-md">Delivered</button>
                    {{-- <button class="w-full bg-orange-200 text-orange-600 text-xs font-bold uppercase p-2 rounded-md">Return</button> --}}
                    @else
                    <a href="/generate-invoice/{{encrypt($order->order_id)}}"><button class="w-full  text-white bg-indigo-500 p-2 rounded-md">Invoice</button></a>
                    <button class="w-full text-white bg-indigo-500 p-2 rounded-md">Track</button>
                    <button onclick="orderCancel('{{encrypt($order->id)}}')" class="w-full text-white bg-indigo-500 p-2 rounded-md">Cancel</button>
                    @endif
                </div>
            </div>
             @endforeach
            </div>
        </div>
    </div>
</div> 
<div id="filteroverlay" onclick="closeFilter()" class="hidden bg-black opacity-50 w-full h-full fixed top-0">
</div>
<div id="filteroption" class="lg:hidden hidden bg-white fixed z-40 shadow-inner shadow-md shadow-black bottom-0 w-full">
    <h5 class="text-2xl font-extrabold p-2">Filter</h5>
    <div class="p-5">
        <h6 class="font-medium py-2">Order Status</h6>
        <ul class="w-full grid grid-cols-3 text-base">
            <li><button onclick="addToFilterList(this,'transit','os')" class="p-2 m-1 border rounded-xl">Transit</button></li>
            <li><button onclick="addToFilterList(this,'delivered','os')" class="p-2 m-1 border rounded-xl">Recived</button></li>
            <li><button onclick="addToFilterList(this,'cancelled','os')" class="p-2 m-1 border rounded-xl">Cancelled</button></li>
            <li><button onclick="addToFilterList(this,'refunded','os')" class="p-2 m-1 border rounded-xl">refunded</button></li>
        </ul>
    </div>
    <div class="p-5">
        <h6 class="font-medium py-2">Order Time</h6>
        <ul id="ordertime" class="w-full flex flex-wrap text-base">
            <li><button onclick="addToFilterList(this,30,'ot')" class="p-2 m-1 border rounded-xl">Last 30 days</button></li>
            <li><button onclick="addToFilterList(this,60,'ot')" class="p-2 m-1 border rounded-xl">Last 60 days</button></li>
            @for ($i = 0; $i < 5; $i++)
            <li><button onclick="addToFilterList(this,{{date('Y')-$i}},'ot')" class="p-2 m-1 border rounded-xl">{{date("Y")-$i}}</button></li>
            @endfor
        </ul>
    </div>
    <div class="pt-5 flex justify-between gap-2 px-2 pb-2">
        <button onclick="closeFilter()" class="p-2 w-full bg-indigo-200 font-medium">Close</button>
        <button id="submitorderfilter" class="p-2 w-full bg-indigo-600 font-medium text-white">Apply</button>

    </div>
</div>
@endsection

@section('bodyscript')
    <script>

        function filterAjax(data)
        {
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                data: data,
                url: "/order-filter",
                beforeSend: function(){
                    $("#process").removeClass('hidden');
                },
                success: function(res)
                {
                    $("#process").addClass('hidden');
                    let x = '';
                    if(res != 0)
                    {
                        $.each(res, function(index,order){
                            let products = '';
                            let actions = '';
                        $.each(order.products,function(index, item){
                            products += `<div class="flex justify-between items-center my-2">
                                            <div>
                                                <a href="">`+item.product_name+`</a> <span class="text-xs">x `+item.items+`</span>
                                            </div>
                                            <img class="w-10" src="`+item.images+`" alt="`+item.product_name+`">
                                        </div>`;
                            switch (order.order_status) {
                                case "delivered":
                                    actions = `<div id="status`+order.id+`" class="border-t-2 border-indigo-300 p-2 gap-4 flex justify-between items-center">
                                            <a href="/generate-invoice/`+order.token+`"><button class="w-full text-xs font-bold p-2 uppercase text-white bg-indigo-500 rounded-md">Invoice</button></a>
                                            <button class="w-full bg-green-200 text-green-600 text-xs font-bold uppercase p-2 rounded-md">Delivered</button>
                                            <button class="hidden w-full bg-orange-200 text-orange-600 text-xs font-bold uppercase p-2 rounded-md">Return</button>
                                        </div>`
                                    break;
                                case "refunded":
                                actions = `<div id="status`+order.id+`" class="border-t-2 border-indigo-300 p-2 gap-4 flex justify-between items-center">
                                    <button class="w-full bg-yellow-200 text-yellow-600 text-xs font-bold uppercase p-2 rounded-md">Refunded</button>                                        
                                    </div>`
                                    break;
                                case "transit":
                                actions = `<div id="status`+order.id+`" class="border-t-2 border-indigo-300 p-2 gap-4 flex justify-between items-center">
                                            <a href="/generate-invoice/`+order.token+`"><button class="w-full text-white bg-indigo-500 p-2 rounded-md">Invoice</button></a>
                                            <button class="w-full text-white bg-indigo-500 p-2 rounded-md">Track</button>
                                            <button onclick="orderCancel('`+order.tid+`')" class="w-full text-white bg-indigo-500 p-2 rounded-md">Cancel</button>
                                        </div>`
                                    break;
                                case "cancelled":
                                actions = `<button class="w-full bg-red-200 text-red-600 text-xs font-bold uppercase p-2 rounded-md">Cancelled</button>`
                                    break;
                                default:
                                    actions = `<div class='text-center my-20'>Order Not Found!</div>`
                                    break;
                            }
                        })
                        x += ` <div class="p-4 border border-indigo-100 rounded-md h-fit">
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="font-bold">#`+order.order_id+`</p>
                                                <p class="font-semibold text-indigo-300 text-xs px-1">`+order.date+`</p>
                                            </div>
                                            <div class="rounded-full w-10 h-10 bg-indigo-200 font-bold text-indigo-500 flex justify-center items-center text-xs">₹`+Math.round(order.total)+`</div>
                                        </div>
                                        <div class="my-5 font-medium text-sm text-gray-500 h-28 overflow-auto">
                                            `+ products +`
                                        </div>
                                        `+ actions +`
                                    </div>`
                        $("#myorders").html(x)
                        })
                    }
                    else
                        $("#myorders").html(`<div class="text-center my-20 col-span-3 text-xl font-bold text-indigo-600">Order Not Found!</div>`)
                }
            })
        }

        $("#search").on("change",function(){
            let key = ($(this).val()).replace('#','');
            if((key).length > 5)
            {
                $.ajax({
                    type: 'get',
                    url: "/search-order/"+key,
                    beforeSend: function()
                    {
                        $("#process").removeClass('hidden');
                    },
                    success: function(res)
                    {
                        $("#process").addClass('hidden');
                        $("#search").val('');
                        console.log(res)
                        if(res != 0)
                        {
                                let products = '';
                                let actions = '';
                            $.each(res.products,function(index, item){
                                products += `<div class="flex justify-between items-center my-2">
                                                <div>
                                                    <a href="">`+item.product_name+`</a> <span class="text-xs">x `+item.items+`</span>
                                                </div>
                                                <img class="w-10" src="`+item.images+`" alt="`+item.product_name+`">
                                            </div>`;
                                switch (res.order_status) {
                                    case "delivered":
                                        actions = `<div id="status`+res.id+`" class="border-t-2 border-indigo-300 p-2 gap-4 flex justify-between items-center">
                                                <a href="/generate-invoice/`+res.token+`"><button class="w-full text-xs font-bold p-2 uppercase text-white bg-indigo-500 rounded-md">Invoice</button></a>
                                                <button class="w-full bg-green-200 text-green-600 text-xs font-bold uppercase p-2 rounded-md">Delivered</button>
                                                <button class="hidden w-full bg-orange-200 text-orange-600 text-xs font-bold uppercase p-2 rounded-md">Return</button>
                                            </div>`
                                        break;
                                    case "refunded":
                                    actions = `<div id="status`+res.id+`" class="border-t-2 border-indigo-300 p-2 gap-4 flex justify-between items-center">
                                        <button class="w-full bg-yellow-200 text-yellow-600 text-xs font-bold uppercase p-2 rounded-md">Refunded</button>                                        
                                        </div>`
                                        break;
                                    case "transit":
                                    actions = `<div id="status`+res.id+`" class="border-t-2 border-indigo-300 p-2 gap-4 flex justify-between items-center">
                                                <a href="/generate-invoice/`+res.token+`"><button class="w-full text-white bg-indigo-500 p-2 rounded-md">Invoice</button></a>
                                                <button class="w-full text-white bg-indigo-500 p-2 rounded-md">Track</button>
                                                <button onclick="orderCancel('`+res.tid+`')" class="w-full text-white bg-indigo-500 p-2 rounded-md">Cancel</button>
                                            </div>`
                                        break;
                                    case "cancelled":
                                    actions = `<button class="w-full bg-red-200 text-red-600 text-xs font-bold uppercase p-2 rounded-md">Cancelled</button>`
                                        break;
                                    default:
                                        actions = `<div class='text-center my-20'>Order Not Found!</div>`
                                        break;
                                }
                            })
                            const x = ` <div class="p-4 border border-indigo-100 rounded-md h-fit">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p class="font-bold">#`+res.order_id+`</p>
                                                    <p class="font-semibold text-indigo-300 text-xs px-1">`+res.date+`</p>
                                                </div>
                                                <div class="rounded-full w-10 h-10 bg-indigo-200 font-bold text-indigo-500 flex justify-center items-center text-xs">₹`+Math.round(res.total)+`</div>
                                            </div>
                                            <div class="my-5 font-medium text-sm text-gray-500 h-28 overflow-auto">
                                                `+ products +`
                                            </div>
                                            `+ actions +`
                                        </div>`
                            $("#myorders").html(x)
                        }
                        else
                            $("#myorders").html(`<div class="text-center my-20 col-span-3 text-xl font-bold text-indigo-600">Order Not Found!</div>`)
                    }
                })
            }
        })
        function orderCancel(id)
        {
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                data: {id},
                url: "/order-cancel",
                beforeSend: function(){
                    $("#process").removeClass('hidden');
                },
                success: function(res)
                {
                    $("#process").addClass('hidden');
                    $(res.id).html('<button class="w-full text-white bg-red-500 p-2 rounded-md">Cancelled</button>');
                    Toast.fire({
                        icon: 'success',
                        title: "Order Cancelled Successfully"
                    })
                }
            })
        }
        function generateInvoice(id)
        {
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                data: {id},
                url: "/generate-invoice",
                beforeSend: function(){
                    $("#process").removeClass('hidden');
                },
                success: function()
                {
                    $("#process").addClass('hidden');
                }
            })
        }
        function orderFilter(ele, x)
        {
            $(".orderfilter").removeClass(["outline-none", "text-4xl", "font-extrabold", "text-black"])
            $(ele).addClass(["outline-none", "text-4xl", "font-extrabold", "text-black"])
            filterAjax({'id': x});
        }
        $("#morderfilter").click(function()
        {
            $("#filteroverlay").fadeIn();
            $("#filteroption").slideDown();
        })
        let filterList = {
            orderStatus: [],
            orderTime: {
                days: null,
                year: null
            }
        };
        function closeFilter()
        {
            $("#filteroverlay").fadeOut();
            $("#filteroption").slideUp();
        }
        function removeItem(arr, id)
        {
            let newlist = [];
            $.each(arr, function(index, item){
                if(item != id)
                {
                    newlist.push(item)
                }
            })
            return newlist;
        }
        function addToFilterList(ele, id, type)
        {
            console.log(filterList)

            if(type == 'os')
            {
                if(filterList.orderStatus.includes(id))
                {
                    $(ele).removeClass(['bg-indigo-600','text-white'])
                    filterList.orderStatus = removeItem(filterList.orderStatus,id);
                }    
                else
                {
                    $(ele).addClass(['bg-indigo-600','text-white'])
                    filterList.orderStatus.push(id)
                }
            }
            else if(type == 'ot')
            {
                $("#ordertime li button").removeClass(['bg-indigo-600','text-white']);

                if(id == 30 || id == 60)
                {
                    filterList.orderTime.days = id;
                    filterList.orderTime.year = null;
                    $(ele).addClass(['bg-indigo-600','text-white'])
                }
                else
                {
                    if(id == filterList.orderTime.year)
                    {
                        filterList.orderTime.year = null;
                    }
                    else
                    {
                        filterList.orderTime.year = id;
                        filterList.orderTime.days = null;
                        $(ele).addClass(['bg-indigo-600','text-white'])
                    }

                }
            }
        }
        $("#submitorderfilter").click(function(){
            
            const check = filterList.orderStatus.length > 0 ? true : filterList.orderTime.days != null ? true : filterList.orderTime.year != null ? true : false;
            if(check)
            {
               filterAjax({'filter': filterList})
               $("#morderfilter div").removeClass('hidden').text((filterList.orderStatus.length))
                closeFilter();
            }
        })
    </script>
@endsection