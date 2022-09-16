<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class supportController extends Controller
{
    public $wish, $cart;
    function __construct()
    {
        $this->wish = new wishlistController;
        $this->cart = new cartController;
    }
}
