<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wishlist;
use App\Models\product;
use App\Http\Controllers\HomeController;
use Alert;

use Auth;

class wishlistController extends Controller
{

    function addwish(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'user_id' => 'required',

        ]);
        $wish = new wishlist;
        $wishcount = $wish->create($request);
        if($wishcount != 'error')
        return response()->json($wishcount, 200);
        else
        return response()->json(array('status'=>'warning','msg'=>"already added to wishlist"), 409);
    }

    function getUserWishCount()
    {
        if(!Auth::check())
        return 0;
        return wishlist::where('user_id',Auth::user()->id)->count();
    }
    function getUserWishlist()
    {
        if(!Auth::check())
        return 0;
        return product::select('products.*','wishlists.id as wish_id','stocks.stock','stocks.our_price','stocks.actual_price')->join('wishlists','products.id','wishlists.product_id')->join('stocks','products.id','stocks.product_id')->join('categories','categories.id','products.cat_id')->where('wishlists.user_id',Auth::user()->id)->get();
    }
    function wishlist()
    {
        $cartcount = (new supportController)->cart->getcartcount();
        $wishcount = $this->getUserWishCount();
        $wishlists = $this->getUserWishlist();
        return view('pages.wishlist',['wishlists'=>$wishlists,'cartcount'=>$cartcount, 'wishcount'=>$wishcount]);
    }
    function wishdelete($id)
    {
        $wish = new wishlist;
        $wish->wdelete($id);
        Alert::toast('Successfully Removed','success');
        return redirect()->back();
    }
}
