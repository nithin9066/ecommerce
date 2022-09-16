@extends('layouts.app')
@section('content')
    <div class="h-screen lg:p-40 lg:m-0 mt-32 p-5 text-center">
        <div>
            <h1 class="text-6xl font-bold">Thank You</h1>
            <h5 class="text-xl font-bold">for shopping with us!</h5>
            <div class="w-full my-10">
                <div class="">
                    <span class="text-xl font-bold">Order_id: </span><span class="font-bold" id="order_id">{{isset($order_id) ? $order_id : ''}}</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function()
        {
            
            const info = JSON.parse(sessionStorage.getItem("paymentInfo"));
            $("#pay_id").text(info.payment_id)
            $("#order_id").text(info.order_id)

        })
    </script>
@endsection