<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Stock;
use App\Models\cart;
use App\Http\Controllers\wishlistController;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $support;

    public function __construct()
    {
        $this->support = new supportController;
        $this->products = product::select('products.url', 'products.product_name','products.id','products.images','products.images','categories.cat_name')->join('categories','categories.id','products.cat_id')->join('stocks','stocks.product_id','products.id')->where('stocks.stock','>',0)->latest('id')->distinct()->get('products.id')->makeHidden(['created_at','updated_at']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cartcount = $this->support->cart->getcartcount();
        $wishcount = $this->support->wish->getUserWishCount();
        return view('index',['products'=>$this->products,'cartcount'=>$cartcount, 'wishcount'=>$wishcount]);
    }

    function search(Request $request)
    {
        $productObj = new productController;
        $cartcount = $this->support->cart->getcartcount();
        $wishcount = $this->support->wish->getUserWishCount();
        $data = product::join('categories','categories.id','products.cat_id')->join('stocks','stocks.product_id','products.id');
        $categories = $data->select("categories.*")->distinct()->get('categories.cat_name');
        $products = $data->join('quantities','quantities.id','stocks.quantity_id')->select('products.*',"categories.cat_name",'categories.id as cat_id','stocks.stock','stocks.our_price','stocks.actual_price','quantities.id as quantity_id','quantities.quantity')->where("products.description",'LIKE','%'.$request->q.'%')->orwhere("products.product_name",'LIKE','%'.$request->q.'%')->orwhere("categories.cat_name",'LIKE','%'.$request->q.'%')->orwhere("categories.cat_name",'LIKE','%'.$request->q.'%')->get();        
        return view('pages.shop',['searchQuery' => $request->q,'categories'=>$categories, 'products'=>$products,'cartcount'=>$cartcount, 'wishcount'=>$wishcount,'newproduct'=>$productObj->NewProducts(), 'popular'=>$productObj->PopularProducts()]);
    }

}
