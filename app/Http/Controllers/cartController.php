<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\cart;
use App\Models\product;
use App\Models\Guest;
use App\Models\Stock;
use App\Models\Quantity;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\wishlistController;
use Alert;
class cartController extends Controller
{

    function __construct()
    {
        $this->cart = new cart;
    }
    function additem(Request $request)
    {

        $quantity = Quantity::find(Crypt::decrypt($request->quantity))->quantity;
        $request->quantity = Crypt::decrypt($request->quantity);
        $check = cart::where("user_id",Auth::user()->id)->where('product_id',Crypt::decrypt($request->product_id))->where('quantity_id',$request->quantity)->count();
        if($check > 0)
        {
            return response()->json(array('message'=>"Product Already Added To cart"), 409);
        }
        $request->validate([
            'product_id' => 'required',
            'user_id' => 'required',
        ]);
        $request->stock_id = Stock::where('product_id',Crypt::decrypt($request->product_id))->where('quantity_id',$request->quantity)->get()->first()->id;
        $this->cart->create($request);
        return response()->json($this->getcartcount(), 200);
    }
    public function getcartcount()
    {
        if(Auth::check())
        return cart::where('user_id','=',Auth::user()->id)->sum('items');
        return 0;
    }
    function getStock($product_id, $quantity_id)
    {
        return Stock::where('product_id',$product_id)->where('quantity_id',$quantity_id)->get('stock')->first()->stock;
    }
    function getUserCart()
    {
        if(!Auth::check())
        return 0;
        return cart::select('products.product_name','products.id','products.images','carts.id as cart_id','carts.items','carts.quantity_id','quantities.quantity','stocks.stock','stocks.our_price','stocks.actual_price')->join('quantities','carts.quantity_id','quantities.id')->join('products','products.id','carts.product_id')->join('stocks','carts.stock_id','stocks.id')->where('carts.user_id',Auth::user()->id);
    }
    function getUserCartPrice()
    {
        $data = product::join('carts','products.id','carts.product_id')->join('stocks','products.id','stocks.product_id')->join('categories','categories.id','products.cat_id')->where('carts.user_id',Auth::user()->id)->where('stocks.stock','>',0)->get();
        $subtotal = 0;
        foreach($data as $da)
        {
            $subtotal += $da->our_price * $da->items;
        }
        return $subtotal;

    }
    function cart()
    {    
       if(Auth::check())
        {
            $obj = new wishlistController;
            $cartcount = $this->getcartcount();
            $wishcount = $obj->getUserWishCount();
            $data = $this->getUserCart() ? $this->getUserCart()->get() : [];
            $subtotal = $this->getUserCartPrice();
            return view('pages.cart',['subtotal'=>$subtotal, 'cart'=>$data,'cartcount'=>$cartcount, 'wishcount'=>$wishcount]);
        }
        else
        return view('pages.cart');
    }

    function delCartItem(Request $request)
    {
        $del = cart::find($request->id);
        $del->delete();
        Alert::toast("Successfully Removed",'success');
    }
    function getCartAmount()
    {
        $data = cart::select('stocks.our_price','carts.items')->join('products','products.id','carts.product_id')->join('stocks','stocks.product_id','carts.product_id')->where('carts.user_id',Auth::user()->id)->where('stocks.stock','>',0)->get();
        $total = 0;
        foreach($data as $da)
        {
            $total += $da->our_price * $da->items;
        }
        return $total;
    }

    function updatecart(Request $request)
    {
        $up = cart::find($request->id);
        $up->items = $request->items;
        $up->save();
        $subtotal = $this->getUserCartPrice();
        $tax = round(($subtotal * 0.03),2);
        $shipping = 50;
        $total = round(($subtotal + $tax + $shipping), 2);

        return response()->json(array("cartcount"=>$this->getcartcount(),"subtotal"=>$subtotal, "tax" => $tax, "shipping" => $shipping, "total" => $total), 200);
        
    }




// Guest cart

    function updateGuestCart($request, $items, $data)
    {
        $sessionCart = $request->session()->get('guestcart');
            
        foreach($sessionCart as $cart)
        {
            if($cart->product_id == $data->product_id && $cart->quantity_id == $data->quantity_id)
            {
                $cart->items++;
                $items = 0;
            }
        }
        if($items == 1)
        {
            $GuestCart = $request->session()->get('guestcart');
            array_push($GuestCart, $data);
            $request->session()->put('guestcart',$GuestCart);
        }
        else
        $request->session()->put('guestcart',$sessionCart);
    }
    
    function getGuestItemsCount() : int
    {
        if(\request()->session()->has('guestcart'))
        {
            $sessionCart = request()->session()->get('guestcart');
            $itemCount = 0;
            foreach($sessionCart as $cart)
            {
                $itemCount += $cart->items;
            }
            return $itemCount;
        }
        else
            return 0;
    }
    function calsubtotal()
    {
        if(\request()->session()->has('guestcart'))
        {
            $data = request()->session()->get('guestcart');
            $subtotal = 0;
            foreach($data as $da)
            {
                if($da->stock > 0)
                {
                    $subtotal += $da->our_price * $da->items;
                }
            }
            return $subtotal;
        }
        else
            return 0;
    }
    function getguestcart()
    {
        $data = request()->session()->get('guestcart');
        $guestcartdata = array();
        foreach($data as $da)
        {
            if($da->stock > 0)
            {
                array_push($guestcartdata, $da);
            }
        }
        return $guestcartdata;
    }

    function guestcart(Request $request)
    {
        $items = 1;
        $flag = false;
        $data = product::select('stocks.*','quantities.quantity','products.product_name','products.id as product_id','products.images')->join('stocks','stocks.product_id','products.id')->join('quantities','quantities.id','stocks.quantity_id')->where('products.id',Crypt::decrypt($request->id))->where('stocks.quantity_id',Crypt::decrypt($request->quantity))->get()->first()->makeHidden(['created_at','updated_at']);
        $data->items = $items;

        if($request->session()->has('guestcart'))
        {
            foreach($request->session()->get('guestcart') as $da)
            {
                if($da->product_id == $data->product_id && $da->quantity == $data->quantity)
                {
                    $flag = true;
                    break;
                }
            }
        
            if($flag)
            {
                return response()->json(array("status"=>"warning", "msg"=>"Product Already Added To cart"), 403);
            }
            else
            {
                $temp = $request->session()->get('guestcart');
                array_push($temp, $data);
                $request->session()->put('guestcart',$temp);
            }
            // $this->updateGuestCart($request, $items, $data);
            // $data = $request->session()->get('guestcart');
        }
        else
        {
            $GuestCart = array();
            array_push($GuestCart, $data);
            $request->session()->put('guestcart',$GuestCart);
            $data = $request->session()->get('guestcart');
        }
        $res = array('cartcount' => $this->getGuestItemsCount(), "data" => $data);
        return response()->json($res, 200);
    }
    
    function editguestcart(Request $request)
    {
        $guestCart = $request->session()->get('guestcart');
        foreach($guestCart as $cart)
        {
            if($cart->id == $request->id)
            {
                $cart->items = $request->items;
            }
        }
        $request->session()->put('guestcart',$guestCart);
        $subtotal = $this->calsubtotal();
        $tax = round($subtotal * 0.03, 2);
        $shipping = 50;
        $data = array(
            "subtotal" => $subtotal,
            "tax" => $tax,
            "shipping" => $shipping,
            "total" => round($subtotal + $tax + $shipping, 2),
            "cartcount" => $this->getGuestItemsCount()
        );
        return response()->json($data, 200);

    }
    
    function guestitemdel(Request $request)
    {
        $guestCart = $request->session()->get('guestcart');
        $temp = array();
        foreach($guestCart as $cart)
        {
            if($cart->id != $request->id)
            {
                array_push($temp, $cart);
            }
        }
        $request->session()->put('guestcart',$temp);
        $subtotal = $this->calsubtotal();
        $tax = round($subtotal * 0.03, 2);
        $shipping = 50;
        $data = array(
            "subtotal" => $subtotal,
            "tax" => $tax,
            "shipping" => $shipping,
            "cartcount" => $this->getGuestItemsCount()
        );
        return response()->json($data, 200);
    }
}
