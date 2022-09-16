<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body>
    <button id="btn">Test</button>

    <script type="text/javascript" src="https://checkout.razorpay.com/v1/razorpay.js"></script>
    <script>
        var razorpay = new Razorpay({
        key: 'rzp_test_IujduIpQSrEEzc',
            // logo, displayed in the payment processing popup
        image: 'https://i.imgur.com/n5tjHFD.jpg',
        });
        var data = {
        amount: 500*100, // in currency subunits. Here 1000 = 1000 paise, which equals to ₹10
        currency: "INR",// Default is INR. We support more than 90 currencies.
        email: 'gaurav.kumar@example.com',
        contact: '9123456780',
        notes: {
            address: 'Ground Floor, SJR Cyber, Laskar Hosur Road, Bengaluru',
        },
        order_id: 'order_KCaujRf6EOniGo',// Replace with Order ID generated in Step 4
        method: 'upi',

        // method specific fields
        vpa: 'test@ybl'
        };

var btn = document.querySelector('#btn');
btn.addEventListener('click', function(){
  // has to be placed within user initiated context, such as click, in order for popup to open.
  razorpay.createPayment(data);

  razorpay.on('payment.success', function(resp) {
    console.log(resp),
    console.log(resp.razorpay_payment_id),
    console.log(resp.razorpay_order_id),
    console.log(resp.razorpay_signature)}); // will pass payment ID, order ID, and Razorpay signature to success handler.

  razorpay.on('payment.error', function(resp){console.log(resp),console.log(resp.error.description)}); // will pass error object to error handler
})
    </script>
</body>

</html>