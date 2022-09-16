<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\category;
use App\Models\Stock;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;
use App\Http\Controllers\wishlistController;
use App\Http\Controllers\cartController;


class productController extends Controller
{
    function __construct()
    {
        $this->wish = new wishlistController;
        $this->cart = new cartController;
    }
    function NewProducts()
    {
        return product::select('products.*',"categories.cat_name",'stocks.stock','stocks.our_price','stocks.actual_price')->join('stocks','stocks.product_id','products.id')->join('categories','categories.id','products.cat_id')->latest('id')->take(4)->get();
    }
    function PopularProducts()
    {
        return product::select('products.*',"categories.cat_name",'stocks.stock','stocks.our_price','stocks.actual_price')->join('stocks','stocks.product_id','products.id')->join('categories','categories.id','products.cat_id')->latest('id')->take(4)->get();
    }
    function product($url)
    {
        $cartcount = $this->cart->getcartcount();
        $wishcount = $this->wish->getUserWishCount();
        $product = product::select('products.*',"categories.cat_name",'stocks.stock','stocks.our_price','stocks.actual_price')->join('stocks','stocks.product_id','products.id')->join('categories','categories.id','products.cat_id')->where("products.url",$url)->get()->first();
        $quantities = Stock::select('quantities.quantity','quantities.id')->join('quantities','stocks.quantity_id','quantities.id')->where('stocks.product_id',$product->id)->get();
        return view('pages.product',['quantities'=>$quantities,'product'=>$product,'cartcount'=>$cartcount, 'wishcount'=>$wishcount,'newproduct'=>$this->NewProducts(), 'popular'=>$this->PopularProducts()]);
    }
    function products()
    {
        $cartcount = $this->cart->getcartcount();
        $wishcount = $this->wish->getUserWishCount();
        $data = product::join('categories','categories.id','products.cat_id')->join('stocks','stocks.product_id','products.id');
        $categories = $data->select("categories.*")->distinct()->get('categories.cat_name');
        $products = $data->join('quantities','quantities.id','stocks.quantity_id')->select('products.*',"categories.cat_name",'categories.id as cat_id','stocks.stock','stocks.our_price','stocks.actual_price','quantities.id as quantity_id','quantities.quantity')->get();        
        return view('pages.shop',['categories'=>$categories, 'products'=>$products,'cartcount'=>$cartcount, 'wishcount'=>$wishcount,'newproduct'=>$this->NewProducts(), 'popular'=>$this->PopularProducts()]);
    }
    function category($cat_name)
    {
        $cat_name = \Str::upper(\Str::replace('-',' ',$cat_name));
        $cartcount = $this->cart->getcartcount();
        $wishcount = $this->wish->getUserWishCount();
        $data = product::join('categories','categories.id','products.cat_id')->join('stocks','stocks.product_id','products.id');
        $categories = $data->select("categories.*")->distinct()->get('categories.cat_name');
        $products = $data->join('quantities','quantities.id','stocks.quantity_id')->select('products.*',"categories.cat_name",'categories.id as cat_id','stocks.stock','stocks.our_price','stocks.actual_price','quantities.id as quantity_id','quantities.quantity')->where("categories.cat_name",$cat_name)->get();
        return view('pages.shop',['categories'=>$categories,'products'=>$products,'cartcount'=>$cartcount, 'wishcount'=>$wishcount,'newproduct'=>$this->NewProducts(), 'popular'=>$this->PopularProducts()]);
    }

    function filter(Request $request)
    {

        if(isset($request->filter['cats']) && count($request->filter['cats']) > 0)
        $data = product::join('categories','categories.id','products.cat_id')->join('stocks','stocks.product_id','products.id')->join('quantities','quantities.id','stocks.quantity_id')->select('products.*','products.id as product_id',"categories.cat_name",'categories.id as cat_id','stocks.stock','stocks.our_price','stocks.actual_price','quantities.id as quantity_id','quantities.quantity')->whereIn('products.cat_id',$request->filter['cats']);
        else
        $data = product::join('categories','categories.id','products.cat_id')->join('stocks','stocks.product_id','products.id')->join('quantities','quantities.id','stocks.quantity_id')->select('products.*','products.id as product_id',"categories.cat_name",'categories.id as cat_id','stocks.stock','stocks.our_price','stocks.actual_price','quantities.id as quantity_id','quantities.quantity');

        if(isset($request->filter['stock']) && count($request->filter['stock']) == 1)
        $data = $request->filter['stock'][0] == "in" ? $data->where("stocks.stock",'>',0) : $data->where("stocks.stock",0);
        
        if(isset($request->filter['search']))
        $data = $request->filter['sort'] == "latest" ? $data->latest('id')->where("products.description",'LIKE','%'.$request->filter['search'].'%')->orwhere("products.product_name",'LIKE','%'.$request->filter['search'].'%')->orwhere("categories.cat_name",'LIKE','%'.$request->filter['search'].'%')->orwhere("categories.cat_name",'LIKE','%'.$request->filter['search'].'%')->get() : ($request->filter['sort'] == "ASC" ? $data->orderby("stocks.our_price", "ASC")->where("products.description",'LIKE','%'.$request->filter['search'].'%')->where("products.product_name",'LIKE','%'.$request->filter['search'].'%')->orwhere("categories.cat_name",'LIKE','%'.$request->filter['search'].'%')->orwhere("categories.cat_name",'LIKE','%'.$request->filter['search'].'%')->get() : $data->orderby("stocks.our_price", "DESC")->where("products.description",'LIKE','%'.$request->filter['search'].'%')->where("products.product_name",'LIKE','%'.$request->filter['search'].'%')->orwhere("categories.cat_name",'LIKE','%'.$request->filter['search'].'%')->orwhere("categories.cat_name",'LIKE','%'.$request->filter['search'].'%')->get()); 
        else
        $data = $request->filter['sort'] == "latest" ? $data->latest('id')->get() : ($request->filter['sort'] == "ASC" ? $data->orderby("stocks.our_price", "ASC")->get() : $data->orderby("stocks.our_price", "DESC")->get()); 
        
        foreach($data as $da)
        {
            $da->product_id = Crypt::encrypt($da->product_id);
            $da->quantity_id = Crypt::encrypt($da->quantity_id);
        }
        return response()->json(array("auth"=>\Auth::check(), "id"=> \Auth::check() ? Crypt::encrypt(\Auth::user()->id) : '', "data" => $data), 200);
    }
}
