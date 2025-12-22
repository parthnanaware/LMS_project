<?php

namespace App\Http\Controllers;

use App\Models\tbl_cart;
use App\Models\tbl_enrolment;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ================= GET CART =================
    public function getCart($user_id)
    {
        $cart = tbl_cart::where('carts.user_id', $user_id)
            ->join('tbl_corse', 'tbl_corse.course_id', '=', 'carts.course_id')
            ->select(
                'carts.cart_id',
                'carts.course_id',
                'tbl_corse.course_name',
                'tbl_corse.mrp',
                'tbl_corse.sell_price',
                'tbl_corse.course_image'
            )
            ->get();

        foreach ($cart as $item) {
            $item->course_image_url = $item->course_image
                ? "https://61ae0168b457.ngrok-free.app/uploads/" . $item->course_image
                : null;
        }

        return response()->json([
            'status' => 'success',
            'data' => $cart
        ]);
    }

    // ================= ADD TO CART =================
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        $exists = tbl_cart::where('user_id', $request->user_id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Already in cart'
            ], 400);
        }

        tbl_cart::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'quantity' => 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart'
        ]);
    }

    // ================= REMOVE CART =================
    public function removeCart($cart_id)
    {
        tbl_cart::where('cart_id', $cart_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Removed'
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $cartItems = tbl_cart::where('user_id', $request->user_id)
            ->join('tbl_corse', 'tbl_corse.course_id', '=', 'carts.course_id')
            ->select(
                'carts.course_id',
                'tbl_corse.mrp',
                'tbl_corse.sell_price'
            )
            ->get();

        foreach ($cartItems as $item) {

            $exists = tbl_enrolment::where('student_id', $request->user_id)
                ->where('course_id', $item->course_id)
                ->first();

            if ($exists) continue;

            tbl_enrolment::create([
                'student_id' => $request->user_id,
                'course_id' => $item->course_id,
                'mrp' => $item->mrp,
                'sell_price' => $item->sell_price,
                'status' => 'pending' // 🔥 IMPORTANT
            ]);
        }

        // clear cart
        tbl_cart::where('user_id', $request->user_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Checkout successful. Waiting for admin approval.'
        ]);
    }
}
