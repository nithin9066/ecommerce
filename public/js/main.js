
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showCloseButton: true,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

$("#addaddress").on('submit', function(e){
    e.preventDefault();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        data: $(this).serialize(),
        url: "/addaddress",
        error: function(){
            $("#process").addClass('hidden');
            alert("something went wrong!");
        },
        success: function(res)
        {
           const address = `<div class="border p-3 rounded-md">
                    <div class="flex items-center">
                        <input checked="true" onclick="updateAddress(this)" type="radio" class="px-2" name="address_id" value="${res.address.id}">
                        <span class="px-2 font-medium">${res.address.name}</span>
                        <span class="px-2 font-medium">${res.address.phone}</span>
                    </div>
                    <p>${res.address.address}</p>
                </div>`
            $("#addresses").prepend(address)
            $("#addaddress-model").addClass("hidden")
            $("[modal-backdrop]").addClass("hidden")
        }
    })
})
$("#login").submit(function (e) {
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/login',
        data: $(this).serialize(),

        success: function (res) {
                location.reload();
        },
        error: function (res) {
            console.log(res.responseJSON)
            const err = res.responseJSON;
            $("#error").text(err.message).removeClass('hidden')
        }

    })
})
$("#signup").submit(function (e) {

    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/register',
        data: $(this).serialize(),

        success: function (res) {
            clearmsg("#regerror");
            $("#success").text("Successfully Registered.").removeClass('hidden')
            location.reload();
        },
        error: function (res) {
            console.log(res.responseJSON)
            const err = res.responseJSON;
            let errorlist = ''
            $.each(err.errors.email, function (index, msg) {
                errorlist += "<li>" + msg + "</li>"
            })
            $.each(err.errors.phone, function (index, msg) {
                errorlist += "<li>" + msg + "</li>"
            })
            $.each(err.errors.password, function (index, msg) {
                errorlist += "<li>" + msg + "</li>"
            })
            $("#regerror").html(errorlist).removeClass('hidden')
        }

    })
})
function clearmsg(id) {
    $(id).text('').addClass('hidden')

}


function addToCart(ele, product_id, user_id) {
    let formdata = null
    if ($("#quantity").length && $("#item").length) {
        formdata = {
            product_id,
            user_id,
            quantity: $("#quantity").val(),
            number: $("#item").val()
        }
    }
    else {
        formdata = {
            product_id,
            user_id,
            quantity: ele.getAttribute("data-helper")
        }
    }
    console.log(formdata)
    $.ajax({
        type: 'post',
        url: '/addcart',
        data: formdata,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function()
        {
            $("#process").removeClass('hidden');
        },
        success: function (res) {
            $("#cartcount, #mcartcount").text(res)
            $("#process").addClass('hidden');
            Toast.fire({
                icon: 'success',
                title: "Added To Cart Successfully"
            })
        },
        error: function(res)
        {
            $("#process").addClass('hidden');
            Toast.fire({
                icon: 'warning',
                title: res.responseJSON.message
            })
        }


    })
}

function addToWish(product_id, user_id) {
    $.ajax({
        type: 'post',
        url: '/addwish',
        data: { product_id, user_id },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function()
        {
            $("#process").removeClass('hidden');
        },
        success: function (res) {
            $("#wishcount, #mwishcount").text(res)
            $("#process").addClass('hidden');
            Toast.fire({
                icon: 'success',
                title: "Added To Wishlist Successfully"
            })
        },
        error: function(res)
        {
            $("#process").addClass('hidden');
            Toast.fire({
                icon: res.responseJSON.status,
                title: res.responseJSON.msg
            })
        }

    })
}


function preview(id) {
    var preimg = document.getElementById("preview");
    var pre = document.getElementsByClassName("si");
    preimg.src = pre[id].src

}
function change(id) {
    $("*.nav-tabs .nav-link").removeClass("active");
    $("." + id).addClass("active")
    $("*#details").addClass('hidden');
    var pre = document.getElementsByClassName("details");
    pre[id].classList.remove('hidden')
    pre[id].classList.add('show')
}


$('#filter input, #sort a, #mfilter input').click(function () {
    const aele = $(this).attr("data-hint");
    let sort = 'latest';
    if (typeof aele !== 'undefined' && aele !== false) {
        sort = aele;
    }
    const ele = document.querySelectorAll("#filter input, #mfilter input")

    let cats = []
    let stock = []
    $.each(ele, function (index, item) {
        if (item.checked) {
            if (item.getAttribute('data-catname') == 'in' || item.getAttribute('data-catname') == 'out')
                stock.push(item.getAttribute('data-catname'))
            else
                cats.push(item.getAttribute('data-catname'))
        }

    })

    let url = window.location.href;

    const urlArray = url.slice("/")

    let filter = {
        cats,
        stock,
        sort
    }

    if(urlArray.includes('search'))
        filter.search = $("#searchquery").text()

    console.log(filter)
    $.ajax({
        type: "post",
        url: '/filter',
        data: { filter },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function()
        {
            $("#process").removeClass('hidden');
        },
        error: function(){
            $("#process").addClass('hidden');
            alert("something went wrong!");
        },
        success: function (response) {
            let ele = ''
            $.each(response.data, function (index, product) {
                let outofstock = ''
                let cartbutton =''
                let addtocart = ''
                let addtowishlist = ''
                if(response.auth)
                {
                    addtocart = `onclick="addToCart(this,'${product.product_id}','${response.id}')" data-helper="${product.quantity_id}"`
                    addtowishlist = `<button class="absolute top-2 right-2" onclick="addToWish('${product.product_id}','${response.id}')">                                    
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--bi text-red-200 hover:font-bold text-xl hover:text-red-500" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" data-icon="bi:heart"><path fill="currentColor" d="m8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385c.92 1.815 2.834 3.989 6.286 6.357c3.452-2.368 5.365-4.542 6.286-6.357c.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"></path></svg>
                                    </button>`
                }
                else
                {
                    addtocart = `onclick="addToGuestCart(this,'${product.product_id}')" data-helper="${product.quantity_id}"`
    
                }
                if(product.stock == 0)
                {
                    outofstock = `<div class="outofstock font-medium text-xl absolute top-0 bg-[#00000082] text-[#ffffff8c] h-full w-full flex justify-center items-center">
                    Out Of Stock </div>`
                }
                else
                {
                    cartbutton = `<button ${addtocart}><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--bi text-indigo-200 hover:text-indigo-600 text-2xl" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16" data-icon="bi:cart-plus"><g fill="currentColor"><path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"></path><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607l1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4a2 2 0 0 0 0-4h7a2 2 0 1 0 0 4a2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0a1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"></path></g></svg></button>
                    `
                }
                ele += `<div class="border relative rounded-sm">
                            <div class="relative">
                                <img src="${product.images}" alt="${product.product_name}">
                                ${outofstock}
                            </div>
                            <div class="bg-slate-100 px-2">
                                ${addtowishlist}
                                <div class="py-2">
                                    <a href="${product.url}">
                                    <h4 class="font-medium pb-2">${product.product_name}</h4>
                                    <h5 class="font-medium pb-2 absolute top-2 left-2 text-slate-400">${product.quantity}</h5>
                                    </a>
                                    
                                    <div class="flex justify-between">
                                        <div>
                                            <span class="line-through px-1">₹${product.actual_price}</span>
                                            <span class="">₹${product.our_price}</span>
                                        </div>
                                        ${cartbutton}
                                    </div>
                                </div>
                            </div>
                        </div>`
            })
            const z = document.getElementById("productslist")
            z.innerHTML = ele
            $("#process").addClass('hidden');
            $("#mfilterbutton").append('<div class="inline-flex absolute -top-1 -right-0 justify-center items-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-white dark:border-gray-900"></div>')
        }
    })

})

function cartItemDel(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'delete',
        url: "/delcartitem",
        data: { id },
        beforeSend: function()
        {
            $("#process").removeClass('hidden');
        },
        error: function(){
            $("#process").addClass('hidden');
            alert("something went wrong!");
        },
        success: function () {
            $("#data"+id).remove()
            $("#process").addClass('hidden');
            Toast.fire({
                icon: 'success',
                title: 'Successfully Removed'
            })
        }
    })
}


$("#orderform").submit(function(e)
{
    e.preventDefault();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        success: function(res)
        {
            if(res.method == "raz")
            {
                var options = {
                    "key": "rzp_test_IujduIpQSrEEzc",
                    "name": "Apsenesys Care",
                    "order_id": res.order_id,
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
                        "name": res.name,
                        "email": res.email,
                        "contact": res.contact
                    },
                    "notes": {
                        "address": "Razorpay Corporate Office"
                    },
                    "theme": {
                        "color": "#0112fe8c"
                    }
                };
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
                rzp1.open();
            }
            else if(res.method == "cod")
            {
                location.href = "/"
            }
        }
    })
})

function updateCart(ele, id)
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: '/updatecart',
        data: {id, items: ele.value},
        beforeSend: function(){
            $("#process").removeClass('hidden');
        },
        error: function(){
            $("#process").addClass('hidden');
            alert("something went wrong!");
        },
        success: function(data)
        {
            // $("#tax").text("₹"+data.tax)
            $("#shipping").text("₹"+data.shipping)
            $("#subtotal").text("₹"+data.subtotal)
            $("#total,#mtotal").text("₹"+data.total)
            $("#process").addClass('hidden');
            $("#cartcount, #mcartcount").text(data.cartcount)
        }
    })
}

