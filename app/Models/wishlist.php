<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Auth;
class wishlist extends Model
{
    use HasFactory;

    function create($request)
    {
        $user_id = Crypt::decrypt($request->user_id);
        $product_id = Crypt::decrypt($request->product_id);
        $ch = wishlist::where('user_id',$user_id)->where('product_id',$product_id)->count();

        if($ch > 0)
        return 'error';
        else
        $add = new wishlist;
        $add->user_id = $user_id;
        $add->product_id = $product_id;
        $add->save();
        return $add->where('user_id',Auth::user()->id)->count();
    }
    function wdelete($id)
    {
        $id = Crypt::decrypt($id);
        $del = wishlist::find($id);
        $del->delete();
    }
}
