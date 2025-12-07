<?php

namespace App\Http\Controllers;

use App\Models\tbl_cart;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\tbl_enrolment;
use App\Models\tbl_corse;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|integer',
            'course_id' => 'required|integer',
        ]);

        $user_id = $request->user_id;
        $course_id = $request->course_id;

        // Check if course exists
        $course = tbl_corse::find($course_id);
        if (!$course) {
            return response()->json([
                'status' => 'error',
                'message' => 'Course not found',
            ], 404);
        }

        // Prevent duplicate cart entry
        $exists = tbl_cart::where('user_id', $user_id)
                      ->where('course_id', $course_id)
                      ->first();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Already in cart.',
            ], 400);
        }

        // ADD TO CART
        $cart = tbl_cart::create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'quantity' => 1,
        ]);

        // ADD ENROLMENT ENTRY
        tbl_enrolment::create([
            'student_id' => $user_id,
            'course_id'  => $course_id,
            'mrp'        => $course->mrp,
            'sell_price' => $course->sell_price,
            'status'     => 'pending', // ⭐ default
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart and enrolment created.',
            'data' => $cart
        ]);
    }

    public function getCart($user_id)
    {
        $cart = tbl_cart::where('user_id', $user_id)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $cart,
        ]);
    }

    public function removeCart($cart_id)
    {
        tbl_cart::where('cart_id', $cart_id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Removed from cart'
        ]);
    }
}
