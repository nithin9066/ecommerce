
function addToGuestCart(ele, id)
{
    localStorage.setItem('uid',id)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        data: {id, quantity: ele.getAttribute("data-helper")},
        url: "/gcart",
        beforeSend: function()
        {
            $("#process").removeClass('hidden');
        },
        success: function(data){
            $("#process").addClass('hidden');
            $("#cartcount").text(data.cartcount)
            Toast.fire({
                icon: 'success',
                title: "Added To Cart Successfully"
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

function changeQuantity(el)
{
    $("#quantity"+$(el).attr('data-help')+" button").removeClass(['border-indigo-600', 'text-indigo-400', 'font-bold'])
    $(el).addClass(['border-indigo-600', 'text-indigo-400', 'font-bold'])
    $("#cart"+$(el).attr('data-help')).attr("data-helper",el.getAttribute("data-q"))
}

function updateGuestCart(ele, id)
{
   $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'post',
    url: '/updateguestcart',
    data: {id, items: ele.value},
    beforeSend: function()
    {
        $("#process").removeClass('hidden');
    },
    success: function(data){
        // $("#tax").text(data.tax)
        $("#shipping").text(data.shipping)
        $("#subtotal").text(data.subtotal)
        $("#total").text(data.total)
        $("#cartcount").text(data.cartcount)
        $("#process").addClass('hidden');
        
        
    }
   })
}
function guestcartItemDel(id)
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: 'guestitemdel',
        data: {id},
        beforeSend: function(){
            $("#process").removeClass('hidden');
        },
        success: function(data)
        {   $("#data"+id).remove()
            // $("#tax").text(data.tax)
            $("#shipping").text(data.shipping)
            $("#subtotal").text(data.subtotal)
            $("#total").text(data.shipping + data.subtotal)
            $("#cartcount").text(data.cartcount)
            $("#process").addClass('hidden');
            Toast.fire({
                icon: 'success',
                title: "Item Removed Successfully"
            })
        }
    })
}