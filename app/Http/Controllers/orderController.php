<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

use Auth;
class orderController extends Controller
{
    function myOrders()
    {
        if(Auth::check())
        {
            $myOrders =  Order::where('user_id',Auth::user()->id)->get();
            foreach($myOrders as $order)
            {
                $order->products =  OrderItem::select('products.product_name','products.images','quantities.quantity','order_items.items')->join('quantities','quantities.id','order_items.quantity_id')->join('products','products.id','order_items.product_id')->where('order_items.order_id',$order->order_id)->distinct()->get('order_items.product_id');
            }
        }
        else
        $myOrders = [];

        return view('pages.orders',\compact("myOrders"));
    }

    function orderCancel(Request $request)
    {
        $request->validate([
            "id" => "required"
        ]);

        $cancel = Order::find(Crypt::decrypt($request->id));
        $cancel->order_status = "cancelled";
        $cancel->save();
        return response()->json(array("id"=>"#status".$cancel->id), 200);
    }
    function generateInvoice($id)
    {
        $subtotal = 0;
        $shipping = 59;
        $details =  OrderItem::select('products.product_name','products.images','quantities.quantity','order_items.items','order_items.order_id','order_items.cost')->join('quantities','quantities.id','order_items.quantity_id')->join('products','products.id','order_items.product_id')->where('order_items.order_id',Crypt::decrypt($id))->distinct()->get('order_items.product_id');
        $address = Address::find(Order::where("order_id",$details[0]->order_id)->get()->first()->address_id);
        foreach($details as $da)
        {
            $subtotal += $da->cost; 
        }
        // return View("pages.invoice",compact("details","address","subtotal","shipping"));
        $pdf = PDF::loadView("pages.invoice",compact("details","address","subtotal","shipping"));
        $pdf->setPaper('a1', 'portrait');
        return $pdf->download('invoice('.date("d-m-Y").').pdf');
    }

    function searchOrder($key)
    {
        $myOrders =  Order::where('user_id',Auth::user()->id)->where('order_id','LIKE',"%{$key}%")->get()->first();
        
        if($myOrders)
        {
            $myOrders->date = \Carbon\Carbon::parse($myOrders->created_at)->format('d-m-Y | h:i:s A');
            $myOrders->token = Crypt::encrypt($myOrders->order_id);
            $myOrders->tid = Crypt::encrypt($myOrders->id);
            $myOrders->products =  OrderItem::select('products.product_name','products.images','quantities.quantity','order_items.items')->join('quantities','quantities.id','order_items.quantity_id')->join('products','products.id','order_items.product_id')->where('order_items.order_id',$myOrders->order_id)->distinct()->get('order_items.product_id');
            return $myOrders;
        }
        else
            return 0;
    }


    function filterYear($request, $myOrders, $years)
    {

        $myOrders->whereYear('created_at',$years);
        return $myOrders;
    }
    function filterDay($request, $myOrders, $days)
    {

        $myOrders->where('created_at', '>', now()->subDays($days)->endOfDay());
        return $myOrders;
    }

    function filterTime($request, $myOrders)
    {
        if(isset($request->filter['orderTime']['days']))
        {
            $myOrders = $this->filterday($request, $myOrders, $request->filter['orderTime']['days']);
        }
        elseif(isset($request->filter['orderTime']['year']))
        {
            $myOrders = $this->filterYear($request, $myOrders, $request->filter['orderTime']['year']);
        }
        return $myOrders->get();
    }

    function orderFilter(Request $request)
    {
        $request->validate([
            "id" => [Rule::in([-1,0,1,2,3])],
        ]);
        
        if(isset($request->id))
        {
            $filter = '';
            switch($request->id)
            {
                case '0':
                $myOrders = Order::where('user_id',Auth::user()->id)->where('order_status',"transit")->get();
                    break;
                case '1':
                $myOrders = Order::where('user_id',Auth::user()->id)->where('order_status',"delivered")->get();
                    break;
                case '2':
                $myOrders = Order::where('user_id',Auth::user()->id)->where('order_status',"cancelled")->get();
                    break;
                case '3':
                $myOrders = Order::where('user_id',Auth::user()->id)->where('order_status',"refunded")->get();
                    break;
                case '-1':
                $myOrders = Order::where('user_id',Auth::user()->id)->get();                
                    break;
                
            }        
            if($myOrders)
            {
                foreach($myOrders as $order)
                {
                    $order->date = \Carbon\Carbon::parse($order->created_at)->format('d-m-Y | h:i:s A');
                    $order->token = Crypt::encrypt($order->order_id);
                    $order->tid = Crypt::encrypt($order->id);
                    $order->products =  OrderItem::select('products.product_name','products.images','quantities.quantity','order_items.items')->join('quantities','quantities.id','order_items.quantity_id')->join('products','products.id','order_items.product_id')->where('order_items.order_id',$order->order_id)->distinct()->get('order_items.product_id');            
                }
                
                return $myOrders;
            }
            else
                return 0;
        }
        elseif(isset($request->filter))
        {
            if(isset($request->filter['orderStatus']) && count($request->filter['orderStatus']) > 0)
                $myOrders = Order::where('user_id',Auth::user()->id)->whereIn('order_status',$request->filter['orderStatus']);
            if(isset($myOrders) && $myOrders && isset($request->filter['orderTime']))
                $myOrders = $this->filterTime($request, $myOrders);
            elseif(!isset($myOrders))
                $myOrders = $this->filterTime($request, Order::where('user_id',Auth::user()->id));
            else
                $myOrders = $myOrders->get();

            if($myOrders)
            {
                foreach($myOrders as $order)
                {
                    $order->date = \Carbon\Carbon::parse($order->created_at)->format('d-m-Y | h:i:s A');
                    $order->token = Crypt::encrypt($order->order_id);
                    $order->tid = Crypt::encrypt($order->id);
                    $order->products =  OrderItem::select('products.product_name','products.images','quantities.quantity','order_items.items')->join('quantities','quantities.id','order_items.quantity_id')->join('products','products.id','order_items.product_id')->where('order_items.order_id',$order->order_id)->distinct()->get('order_items.product_id');            
                }
                
                return $myOrders;
            }
            else
                return 0;
        }
    }

}
