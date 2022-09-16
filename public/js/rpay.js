

var options = {
    "key": "rzp_test_IujduIpQSrEEzc",
    "name": "Apsenesys Care",
    "order_id": "",
    "image": "/logoo.png",
    "handler": function (response){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/paymentProccess',
            data: {response},
            success: function(){
                location.href = '/'
            }
        })
        // alert();
        // alert(response.razorpay_order_id);
        // alert(response.razorpay_signature)
    },
    "prefill": {
        "name": "",
        "email": "",
        "contact": ""
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#0112fe8c"
    }
};

const info = JSON.parse(sessionStorage.getItem('info'));
options.order_id = info.order_id
options.prefill.name = info.name
options.prefill.contact = info.contact
options.prefill.email = info.email

var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/failedpayments',
        data: {'error': response.error},
        success: function(data){
            console.log(data)
        }
    })

});
$(document).ready(function(e){
    rzp1.open();
    e.preventDefault();
})