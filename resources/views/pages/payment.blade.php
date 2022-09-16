@php

use App\Http\Controllers\cartController;
$cartobj = new cartController;

if(request()->session()->has('guestaddress') && !Auth::check())
{
$address = request()->session()->get('guestaddress');
}
@endphp
@extends('layouts.app')
@section('content')
@include('includes.lodder')
<div class="main h-screen">
    <div class="grid grid-cols-3 h-full pb-10">
        <div class="w-full lg:col-span-2 col-span-3 lg:p-14 p-5 h-full overflow-auto relative">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">PAYMENT</h1>
            <div class="lg:mx-10 p-3 my-5 border rounded-md">
                <div class="pb-2 border-b grid grid-cols-4">
                    <span class="mr-5">Contact</span>
                    <span class="ml-5 col-span-3">{{$address['phone']}}</span>
                </div>
                <div class="pt-2 grid grid-cols-4">
                    <div class="mr-5">Ship To</div>
                    <div class="ml-5 col-span-3">{{$address['address'].", ".$address['landmark'].",
                        ".$address['city'].", ".$address['state'].", ".$address['country'].", ".$address['zipcode']}}
                    </div>
                </div>
            </div>
            <div class="">
                <form action="/createorder" method="post">
                    @csrf
                    <h6 class="text-xl font-medium mb-5">Payment Method</h6>
                    <div id="coddiv" class="border flex justify-between pr-2">
                        <div class="flex items-center gap-3 rounded-md p-3 my-2">
                            <input type="checkbox" name="mode" id="cod" value="cod">
                            <label class="font-bold" for="cod">Cash on Delivery (COD)</label>
                        </div>
                        
                    </div>
                </form>
                <div class="border rounded-md">
                    <div id="razor" class="head p-4 border-b border-indigo-400 font-bold " target-toggle="#options">
                        Razorpay  <span class="font-medium text-base">( UPI | NetBanking | Credit/Debit Card )</span>
                    </div>
                    <div id="options" class="hidden">
                        <div class="head p-4 border-b" target-toggle="#fupi">
                            UPI
                        </div>
                        <div class="p-4 hidden options" id="fupi">
                           <form id="upi">
                                <div class="flex flex-col">
                                    <label class="font-bold" for="vpa">UPI ID: </label>
                                    <input required type="text" id="vpa" name="vpa" class="border rounded-md" placeholder="VPA">
                                    <span class='text-red-500 text-xs p-1 font-italic font-bold'></span>
                                </div>
                           </form>
                        </div>
                        <div class="head p-4 border-b" target-toggle="#fnet">
                            Net Banking
                        </div>
                        <div class="p-4 hidden options" id="fnet">
                           <form id="netb" class="flex flex-col justify-center items-start">
                            <label class="font-bold" for="bankname">Bank Name: </label>
                            <select type="text" name="bankname" id="bankname" class="border rounded-md p-2 lg:w-1/2 w-full" title="Select From List">
                            </select>
                            <span class='text-red-500 text-xs p-1 font-italic font-bold'></span>
                            
                           </form>
                        </div>
                        <div class="head p-4 border-b" target-toggle="#tcard">
                            Debit Card/Credit Card
                        </div>
                        <div id="tcard" class="hidden options">
                            <form class="grid grid-cols-12 gap-4 p-4" id="fcard">
                                <div class="lg:col-span-6 col-span-8">
                                    <label class="font-bold" for="card">Card Number:</label>
                                    <input type="number" id="card" name="card" class="w-full border rounded-md"
                                        placeholder="card number">
                                </div>
                                <div class="lg:col-span-2 col-span-4">
                                    <label class="font-bold" for="expiry">Expiry:</label>
                                    <div id="expiry" class="flex gap-2">
                                        <input type="number" name="exmonth" class="border w-1/2 rounded-md text-center" placeholder="MM"
                                            maxlength="2" id="exmonth">
                                        <input type="number" name="exyear" class="border w-1/2 rounded-md text-center" placeholder="YY"
                                            maxlength="2" id="exyear">
                                    </div>
                                </div>
                                <div class="lg:col-span-6 col-span-8">
                                   <div class="flex flex-col">
                                    <label class="font-bold" for="chname">Card Holder's Name</label>
                                    <input class="border rounded-md" id="chname" name="chname" type="text" placeholder="Card Holder's Name">
                                   </div>
                                </div>
                                <div class="lg:col-span-2 col-span-4 flex flex-col">
                                    <label class="font-bold" for="cvv">CVV</label>
                                    <input class="border rounded-md" id="cvv" name="cvv" type="number" placeholder="CVV" maxlength="2">
                                </div>
                                <div class="col-span-12">
                                    <button id="pay" class="lg:relative w-full lg:w-auto fixed bottom-0 left-0 bg-indigo-600 text-white p-2 lg:my-2 rounded-md">Pay Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-10 bg-indigo-50 lg:block hidden">
            <div class="py-3 overflow-auto h-[50vh]">
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
            <div class="flex justify-between py-3 border-t border-indigo-200">
                <span>Subtotal:</span> <span>₹{{$cartobj->calsubtotal()}}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-indigo-200">
                <span>Shipping:</span> <span>₹50</span>
            </div>
            <div class="flex justify-between py-3 border-b border-indigo-200">
                <span>Tax:</span> <span>₹{{$cartobj->calsubtotal()*0.03}}</span>
            </div>
            <div class="flex justify-between py-3 ">
                <span>Total:</span> <span class="text-xl font-bold"><span class="text-xs">INR</span>
                    ₹{{$cartobj->calsubtotal() + ($cartobj->calsubtotal()*0.03) + 50}}</span>
            </div>
        </div>
    </div>
</div>
<form id="gateway" action="/razorpay" method="post">
    @csrf
</form>
@endsection

@section('bodyscript')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript" src="https://checkout.razorpay.com/v1/razorpay.js"></script>
<script>
    $(document).ready(function()
    {
        let xyz = false;
        let info = '';
        let UpiValid = ["focus:border-green-500","focus:ring-green-500","border-green-500"];
        let UpiInvalid = ["focus:border-red-500","focus:ring-red-500","border-red-500"];
        let UpiError = "Invalid Upi Id";
        let netbanking = [];
        var razorpay = new Razorpay({
        
        key: 'rzp_test_IujduIpQSrEEzc',
            // logo, displayed in the payment processing popup
        image: 'https://i.imgur.com/n5tjHFD.jpg',
        });
        var data = {
        amount: 0,
        currency: "INR",// Default is INR. We support more than 90 currencies.
        email: null,
        contact: null,
        notes: {
            address: 'Ground Floor, SJR Cyber, Laskar Hosur Road, Bengaluru',
        },
        order_id: null,// Replace with Order ID generated in Step 4
        };

        function paymentProccess(resp)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/paymentProccess',
                data: {resp},
                success: function(res){
                    console.warn(res.status);
                    if(res.status == "success")
                    {
                        sessionStorage.setItem("paymentInfo", JSON.stringify(res.data));
                        location.href = "/thankyou"
                    }
                    else
                    {
                        alert("something went wrong!")
                    }
                },
                error: function(res)
                {
                    alert("something went wrong!")
                    console.log(res)
                }
            })
        }

        $("#razor").click(function()
        {
            if(!xyz)
            {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: '/createorder',
                    data: {mode:"razorpay"},
                    beforeSend: function(){
                        $("#process").removeClass('hidden');
                    },
                    success: function(res)
                    {
                        $("#process").addClass('hidden');
                        xyz = true;
                        info = res;
                        data.contact = res.contact;
                        data.email = res.email;
                        data.order_id = res.order_id;
                        data.amount = res.amount;
                        
                        for (const x in res.methods.netbanking) {
                            netbanking.push(x)
                            $("#bankname").append("<option value='"+x+"'>"+res.methods.netbanking[x]+"</option>")
                        }
                    }
                })
            }
        })
        $(".head").click(function(){
            $(".options").addClass("hidden");
            $(".head").removeClass(["bg-indigo-500","text-white"]);
            $(this).toggleClass(["bg-indigo-500","text-white"])
            $($(this).attr("target-toggle")).toggleClass("hidden");
        })

        $("#vpa").on('input',function() {
            razorpay.verifyVpa($(this).val())
            .then(() => {
                if($(this).val() !='')
                {
                    $("#upi div span").text("")
                    $(this).removeClass(UpiInvalid).addClass(UpiValid)
                    $("#bupi").remove()
                    $("#upi").append(`<button id="bupi" class="lg:relative w-full lg:w-auto fixed bottom-0 left-0 bg-indigo-600 text-white p-2 lg:my-2 rounded-md">Pay Now</button>`)
                }
                else
                {
                    $("#bupi").remove()
                    $(this).removeClass(UpiValid).addClass(UpiInvalid)
                }
            })
            .catch(() => {
                $("#upi div span").text(UpiError)
                $(this).removeClass(UpiValid).addClass(UpiInvalid)
                $("#bupi").remove()
            });
        })
        $("#upi").on('submit',function(e){
            e.preventDefault();
            data.method = "upi";
            data.vpa = $("#vpa").val();
            
            razorpay.createPayment(data);

            razorpay.on('payment.success', function(resp) {
                    paymentProccess(resp);
                    })

            razorpay.on('payment.error', function(resp){alert(resp.error.description)}); 
            
        })

        $("#netb").on('submit',function(e){
            e.preventDefault();
            data.method = "netbanking";
            data.bank = $("#bankname").val();
            
            razorpay.createPayment(data);

            razorpay.on('payment.success', function(resp) {
                    paymentProccess(resp);
                    })

            razorpay.on('payment.error', function(resp){alert(resp.error.description)}); 
            
        })

        $("#fcard").on('submit', function(e){
            e.preventDefault();
            data.method = "card";
            data.number = $("#card").val();
            data.name = $("#chname").val();
            data.expiry_month = $("#exmonth").val();
            data.expiry_year = $("#exyear").val();
            data.cvv = $("#cvv").val();
            console.log(data)
            razorpay.createPayment(data);

            razorpay.on('payment.success', function(resp) {
                    paymentProccess(resp);
                    })

            razorpay.on('payment.error', function(resp){
                Swal.fire(resp.error.description, "error")
            });
        })
       
        $("#bankname").on('input',function(){
            if(netbanking.includes($(this).val()))
            {
                $("#netb span").text("")
                $(this).removeClass(UpiInvalid).addClass(UpiValid)
                $("#netbtn").remove()
                $("#netb").append(`<button id="netbtn" class="lg:relative w-full lg:w-auto fixed bottom-0 left-0 bg-indigo-600 text-white p-2 lg:my-2 rounded-md">Pay Now</button>`)
            }
            else
            {
                $("#netb span").text("Invalid Bank Name")
                $(this).removeClass(UpiValid).addClass(UpiInvalid)
                $("#netbtn").remove()
            }
        })
        $("#cod").click(function()
        {
           $(this).prop('checked') == true ?  $("#coddiv").append(`<button id="codbtn" class="lg:relative w-full lg:w-auto fixed bottom-0 left-0 bg-indigo-600 text-white p-2 lg:my-2 lg:rounded-md">Place Order</button>`) : $("#coddiv #codbtn").remove()
        })

        $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
    })
</script>
@endsection
@section('style')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
@endsection