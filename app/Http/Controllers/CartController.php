<?php

namespace App\Http\Controllers;

use App\Models\tbl_cart;
use Illuminate\Http\Request;
use App\Models\tbl_corse;

class CartController extends Controller
{
    // ===========================================
    // GET CART WITH FULL COURSE DETAILS
    // ===========================================
      public function getCart($user_id)
    {
        $cart = tbl_cart::where('carts.user_id', $user_id)
            ->join('tbl_corse', 'tbl_corse.course_id', '=', 'carts.course_id')
            ->select(
                'carts.cart_id',
                'carts.user_id',
                'carts.course_id',
                'carts.quantity',
                'tbl_corse.course_name',
                'tbl_corse.sell_price',
                'tbl_corse.course_image'
            )
            ->get();

        // 🔥 Add FULL NGROK BASED IMAGE URL
        foreach ($cart as $item) {
            if ($item->course_image) {
                $item->course_image_url =
                    "https://61ae0168b457.ngrok-free.app/uploads/" . $item->course_image;
            } else {
                $item->course_image_url = null;
            }
        }

        return response()->json([
            'status' => 'success',
            'data'   => $cart
        ]);
    }
    // ===========================================
    // ADD TO CART
    // ===========================================
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        // Check if already in cart
        $exists = tbl_cart::where('user_id', $request->user_id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course already in cart',
            ], 400);
        }

        // Add new item
        $cart = tbl_cart::create([
            'user_id'   => $request->user_id,
            'course_id' => $request->course_id,
            'quantity'  => 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Course added to cart',
            'data' => $cart
        ]);
    }

    // ===========================================
    // REMOVE FROM CART
    // ===========================================
    public function removeCart($cart_id)
    {
        tbl_cart::where('cart_id', $cart_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }
}
