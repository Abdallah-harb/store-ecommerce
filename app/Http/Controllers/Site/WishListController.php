<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;

class WishListController extends Controller
{
        //store products to wishlist[db] and if it exists not added
    public function store(){
            //if it exists on bd not added
        if(! auth()->user()->wishListsHas(request('productId'))){
            //if it not exists on bd  added
            auth()->user()->wishlist()->attach(request('productId'));

            return response()->json(['status' => true,'wished'=> true]);
        }
        return response()->json(['status' => true,'wished'=> false]);

    }

    // get all products on wishlist to show
    public function showWishlist(){
        $products = auth()->user()->wishlist()->latest()->get();
        return view('Front.wishlist.index',compact('products'));
    }

    //delete wishlist
    public function deleteWishlist(){

        return auth()->user()->wishlist()->detach(request('productId'));
    }


}
