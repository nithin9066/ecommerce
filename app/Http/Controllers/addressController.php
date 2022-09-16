<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Models\Address;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Alert;

class addressController extends Controller
{
    public $support, $cart;

    public function __construct()
    {
        $this->support = new supportController;
        $this->cart = new cartController;
    }
    function checkout()
    {
        $cartcount = $this->support->cart->getcartcount();
        $wishcount = $this->support->wish->getUserWishCount();
        $address = Address::where('user_id',Auth::user()->id)->latest("selected")->get();
        return view('pages.checkout',['subtotal'=>$this->support->cart->getUserCartPrice(), 'cart'=> $this->support->cart->getUserCart(), 'addresses'=>$address,'cartcount'=>$cartcount, 'wishcount'=>$wishcount]);
    }
    function guestcheckout()
    {
        return view('pages.checkout');
    }
    function addaddress(Request $request)
    {
        Address::where("user_id",Auth::user()->id)->update(['selected'=>0]);
        $add = new Address;
        $add->user_id = Auth::user()->id;
        $add->name = $request->name;
        $add->phone = $request->phone;
        $add->email = $request->email;
        $add->address = $request->address;
        $add->landmark = $request->landmark;
        $add->zipcode = $request->zipcode;
        $add->city = $request->city;
        $add->state = $request->state;
        $add->country = $request->country;
        $add->selected = 1;
        $add->save();
        $data = array(
            "status" => "success",
            "msg" => "Successfully Added",
            "address" => $add
        );
        $add->id = Crypt::encrypt($add->id);
        return response()->json($data, 200);

    }
    function updateAddress(Request $request)
    {
        $check = Address::find(Crypt::decrypt($request->id));
        if($check)
        {
            Address::where('user_id',Auth::user()->id)->where('selected',1)->update(['selected'=>0]);
            $update = Address::find($check->id);
            $update->selected = 1;
            $update->save();
            return response()->json(['msg'=>'success'], 200);
        }
        else
        return response()->json(['msg'=>'error'], 500);
    }

    function payment()
    {
        $ch = Address::where('user_id',Auth::user()->id)->where('selected',1)->count();
        $cartCheck = $this->cart->getUserCart()->where('stocks.stock','>',0)->count();
        if($ch > 0 && $cartCheck > 0)
        {
            $cartcount = $this->support->cart->getcartcount();
            $wishcount = $this->support->wish->getUserWishCount();
            $address = Address::where('user_id',Auth::user()->id)->where('selected',1)->get()->first();
            return view('pages.payment',['cart'=> $this->cart->getUserCart(), 'address'=>$address,'cartcount'=>$cartcount, 'wishcount'=>$wishcount]);
        }
        else
        {
            Alert::error("Oops! Something Went Wrong Please Try Again.");
            return redirect('cart');
        }
    }
}
