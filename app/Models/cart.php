<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Auth;
class cart extends Model
{
    use HasFactory;

    function create($request)
    {
        $add = new cart;
        $add->user_id = Crypt::decrypt($request->user_id);
        $add->product_id = Crypt::decrypt($request->product_id);
        $add->stock_id = $request->stock_id;
        if($request->number && $request->quantity)
        {
            $add->quantity_id = $request->quantity;
            $add->items = $request->number;
        
        }
        elseif($request->quantity)
        {
            $add->quantity_id = $request->quantity;
        }
        $add->save();
        return $add->where('user_id',Auth::user()->id)->count();
    }
}
