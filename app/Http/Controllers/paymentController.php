<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\GuestOrder;
use App\Models\cart;
use App\Models\User;
use App\Models\Address;
use App\Models\GuestAddress;
use App\Models\FailedTransaction;
use App\Models\OrderItem;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Illuminate\Support\Facades\Http;

use Illuminate\Validation\Rule;


use Auth;
class paymentController extends Controller
{

    public $cart;

    public function __construct()
    {
        $this->cart = new cartController;
    }

    function createorder(Request $req)
    {
        $req->validate([
            'mode' => ['required',Rule::in(['cod','razorpay'])]
        ]);

        if(Auth::check())
        {
            $cart = $this->cart->getUserCart()->where('stocks.stock','>',0)->get();
            $address = Address::where('user_id',Auth::user()->id)->where('selected',1)->get()->first();
        }
        else
        {
            $cart = $this->cart->getguestcart();
            $address = $req->session()->get('guestaddress');
        }

        $cost = 0;
        foreach($cart as $calcost)
        {
            $cost += $calcost->our_price * $calcost->items;
        }
        $cost += $cost + 50;
        
        if($req->mode == "razorpay")
        {
            $key_id = env('RKEY_ID',null);
            $secret = env('RSECRET_KEY',null);
            
            $api = new Api($key_id, $secret);
            
            $data = $api->order->create(array('amount' => $cost*100, 'currency' => 'INR', 'notes'=> array('address'=>$address['address'].", ".$address['landmark'].", ".$address['city'].", ".$address['state'].", ".$address['country'].", ".$address['zipcode'])));
            $methods = Http::get("https://api.razorpay.com/v1/methods?key_id=".$key_id);
            $res = array(
                'method' => 'raz',
                'methods' => $methods->object(),
                'order_id' => $data->id,
                'contact' => $address['phone'],
                'name' => $address['name'],
                'email' => $address['email'],
                'amount' => $data->amount
            );
        }
        else
        {
            if(Auth::check())
            {
                $total = $this->cart->getCartAmount();
                $carts  = cart::select('carts.*','stocks.our_price')->join('products','products.id','carts.product_id')->join('stocks','carts.stock_id','stocks.id')->where('stocks.stock','>',0)->where('carts.user_id',Auth::user()->id)->get();
                $address = address::select('id')->where('user_id',Auth::user()->id)->where('selected',1)->get()->first();
            }
            else
            {
                $total = $this->cart->calsubtotal();
                $carts = $this->cart->getguestcart();
                $address = $req->session()->get('guestaddress');
                $add = new GuestAddress;
                $add->name = $address['name'];
                $add->phone = $address['phone'];
                $add->email = $address['email'];
                $add->address = $address['address'];
                $add->landmark = $address['landmark'];
                $add->zipcode = $address['zipcode'];
                $add->city = $address['city'];
                $add->state = $address['state'];
                $add->country = $address['country'];
                $add->save();
            }
            
                if(Auth::check())
                {
                    $order = new Order;
                    $order->user_id = Auth::user()->id;
                    $order_id = "OD".\Str::replace([':','-',' '],'',((string) \now()));
                }
                else
                {
                    $order = new GuestOrder;
                    $order_id = "ODG".\Str::replace([':','-',' '],'',((string) \now()));
                }

                $order->address_id = Auth::check() ? $address->id : $add->id;
                $order->payment_id = 0;
                $order->order_id = $order_id;
                $order->method = $req->mode;
                $order->status = '0';
                $order->acquirer_data = '0';
                $order->total = $cost;
                $order->save();
                
                if(Auth::check())
                {
                    $cartdestroy = cart::where('user_id',Auth::user()->id)->delete();
                    $order_id = "OD".\Str::replace([':','-',' '],'',((string) \now())).$order->id;
                    $upd = Order::find($order->id);
                    $upd->order_id = $order_id;
                    $upd->save();
                }
                else
                {
                    $req->session()->forget('guestcart');
                    $order_id = "ODG".\Str::replace([':','-',' '],'',((string) \now())).$order->id;
                    $upd = GuestOrder::find($order->id);
                    $upd->order_id = $order_id;
                    $upd->save();
                }
                foreach($carts as $cart)
                {
                    $add = new OrderItem;
                    $add->order_id = $upd->order_id;
                    $add->product_id = $cart->product_id;
                    $add->items = $cart->items;
                    $add->quantity_id = $cart->quantity_id;
                    $add->cost = $cart->our_price*$cart->items;
                    $add->save();
                }
                
                $res = array(
                      'method' => 'cod',
                );
                // $res = array(
                //     'method' => 'cod',
                //     'status' => 200,
                //     'message' => "success",
                //     'order_id' => $add->order_id
                // );
            // $order = User::find(Auth::user()->id);
            // $order->order_id = $data->id;
            // $order->save();
        }

        return $res['method'] == "cod" ?  redirect('/thankyou')->with('order_id', $add->order_id) :  response()->json($res, 200);
    }

    function paymentProccess(Request $req)
    {
        $paymentStatus = 1;
        $key_id = env('RKEY_ID',null);
        $secret = env('RSECRET_KEY',null);
        
        $api = new Api($key_id, $secret);
        $data = $api->payment->fetch($req->resp['razorpay_payment_id']);
        $signature = hash_hmac("sha256",$data->order_id . "|" . $data->id, $secret);

        if($signature != $req->resp['razorpay_signature'])
            $paymentStatus = 9;


        if(Auth::check())
            {
                $total = $this->cart->getCartAmount();
                $carts  = cart::select('carts.*','stocks.our_price')->join('products','products.id','carts.product_id')->join('stocks','carts.stock_id','stocks.id')->where('stocks.stock','>',0)->where('carts.user_id',Auth::user()->id)->get();
                $address = address::select('id')->where('user_id',Auth::user()->id)->where('selected',1)->get()->first();
            }
            else
            {
                $total = $this->cart->calsubtotal();
                $carts = $this->cart->getguestcart();
                $address = $req->session()->get('guestaddress');
                $add = new GuestAddress;
                $add->name = $address['name'];
                $add->phone = $address['phone'];
                $add->email = $address['email'];
                $add->address = $address['address'];
                $add->landmark = $address['landmark'];
                $add->zipcode = $address['zipcode'];
                $add->city = $address['city'];
                $add->state = $address['state'];
                $add->country = $address['country'];
                $add->save();
            }
            
                if(Auth::check())
                {
                    $order = new Order;
                    $order->user_id = Auth::user()->id;
                }
                else
                {
                    $order = new GuestOrder;
                    $order_id = "ODG".\Str::replace([':','-',' '],'',((string) \now()));
                }

            $order->address_id = Auth::check() ? $address->id : $add->id;
            $order->payment_id = $data->id;
            $order->order_id = $data->order_id;
            $order->method = $data->method;
            $order->bank_name = $data->bank;

            $order->status = $paymentStatus;
            $order->total = $total;
            $order->amount_refunded = $data->amount_refunded;
            $order->upi = $data->vpa;
            $order->fee = $data->fee/100;
            $order->tax = $data->tax/100;

            if($data->method == 'card' && isset($data->card))
            $order->card = \json_encode($data->card->toArray());

            $order->acquirer_data = \json_encode($data->acquirer_data->toArray());
            $order->save();
                
                if(Auth::check())
                {
                    $cartdestroy = cart::where('user_id',Auth::user()->id)->delete();
                }
                else
                {
                    $req->session()->forget('guestcart');
                }
                foreach($carts as $cart)
                {
                    $add = new OrderItem;
                    $add->order_id = $order->order_id;
                    $add->product_id = $cart->product_id;
                    $add->items = $cart->items;
                    $add->quantity_id = $cart->quantity_id;
                    $add->cost = $cart->our_price*$cart->items;
                    $add->save();
                }
                
            if($paymentStatus == 9)
                return response()->json(array("status"=>"erroe", "signature" => "Failed"), 500);
            else
                return response()->json(array("status"=>"success", "data" => array("payment_id"=>$data->id, "order_id"=>$data->order_id)), 200);
    }
    function guestpayment(Request $request)
    {
        $request->session()->put('guestaddress',$request->all());
        return view('pages.payment');
    }

    function failedPayments(Request $req)
    {
        $add = new FailedTransaction;
        $add->error = json_encode($req->error);
        $add->save();
    }

    function razorpay()
    {
        return view("pages.razorpay");
    }
    function thankyou(Request $request)
    {   if($request->session()->has('order_id'))
        return view("pages.thankyou",['order_id'=>$request->session()->get('order_id')]);
        else 
        return view("pages.thankyou");
    }
}
