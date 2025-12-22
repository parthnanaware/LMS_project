<?php

namespace App\Http\Controllers;

use App\Models\tbl_enrolment;
use Illuminate\Http\Request;
use App\Models\OrderMaster;
use App\Models\OrderChild;
use App\Models\tbl_cart;
use App\Models\Enrollment;
use Auth;
use DB;

class OrderController extends Controller
{
    public function createOrder()
    {
        $userId = Auth::id();

        $cart = tbl_cart::where('user_id', $userId)->get();

        if ($cart->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        DB::beginTransaction();

        try {
            $total = $cart->sum('sell_price');
            $discount = 0;
            $final = $total;

            $order = OrderMaster::create([
                'user_id' => $userId,
                'total_amount' => $total,
                'discount_amount' => $discount,
                'final_amount' => $final,
                'status' => 'paid',
                'payment_method' => 'Online',
                'payment_id' => 'PAY' . time()
            ]);

            foreach ($cart as $item) {

                OrderChild::create([
                    'order_id' => $order->order_id,
                    'course_id' => $item->course_id,
                    'quantity' => 1,
                    'mrp' => $item->mrp,
                    'sell_price' => $item->sell_price,
                ]);

                tbl_enrolment::create([
                    'student_id' => $userId,
                    'course_id' => $item->course_id,
                    'mrp' => $item->mrp,
                    'sell_price' => $item->sell_price,
                    'status' => 'paid'
                ]);
            }

            tbl_cart::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('order.success', $order->order_id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function orderSuccess($id)
    {
        $order = OrderMaster::with('items.course')->findOrFail($id);
        return view('order-success', compact('order'));
    }


public function apiPlaceOrder($userId)
{
    $cart = tbl_cart::where('user_id', $userId)->get();

    if ($cart->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Cart is empty'
        ], 400);
    }

    DB::beginTransaction();

    try {

        // Calculate total price from course table
        $total = 0;
        foreach ($cart as $item) {
            $course = \App\Models\tbl_corse::find($item->course_id);
            $total += $course->sell_price;
        }

        // Create Order Master
        $order = OrderMaster::create([
            'user_id' => $userId,
            'total_amount' => $total,
            'discount_amount' => 0,
            'final_amount' => $total,
            'status' => 'paid',
            'payment_method' => 'Online',
            'payment_id' => 'PAY' . time()
        ]);

        // Create Order Child + Enrollment
        foreach ($cart as $item) {

            $course = \App\Models\tbl_corse::find($item->course_id);

            OrderChild::create([
                'order_id' => $order->order_id,
                'course_id' => $item->course_id,
                'quantity' => 1,
                'mrp' => $course->mrp,
                'sell_price' => $course->sell_price,
            ]);

            tbl_enrolment::create([
                'student_id' => $userId,
                'course_id' => $item->course_id,
                'mrp' => $course->mrp,
                'sell_price' => $course->sell_price,
                'status' => 'paid'
            ]);
        }

        // Clear Cart
        tbl_cart::where('user_id', $userId)->delete();

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'order_id' => $order->order_id
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


public function adminIndex()
{
    $orders = OrderMaster::with('user')->orderBy('order_id', 'DESC')->get();
    return view('order.ordermaster', compact('orders'));
}

public function adminShow($id)
{
    $order = OrderMaster::with(['user', 'items.course'])->findOrFail($id);
    return view('order.ordershow', compact('order'));
}
public function enrollFromOrder($order_id)
{
    $order = OrderMaster::with(['user', 'items.course'])->findOrFail($order_id);

    $studentId = $order->user_id;

    DB::beginTransaction();

    try {
        foreach ($order->items as $item) {

            $exists = tbl_enrolment::where('student_id', $studentId)
                ->where('course_id', $item->course_id)
                ->exists();

            if (!$exists) {
                tbl_enrolment::create([
                    'student_id' => $studentId,
                    'course_id' => $item->course_id,
                    'mrp' => $item->mrp,
                    'sell_price' => $item->sell_price
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('admin.orders.show', $order_id)
            ->with('success', 'Student enrolled successfully!');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()->with('error', 'Enrollment failed: '.$e->getMessage());
    }
}

}
