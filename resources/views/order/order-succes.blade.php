@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="text-success">Order Successful!</h2>

    <h4>Order ID: {{ $order->order_id }}</h4>
    <h4>Total Paid: ₹{{ $order->final_amount }}</h4>

    <hr>

    <h3>Purchased Courses:</h3>

    <ul>
        @foreach($order->items as $item)
            <li>
                <strong>{{ $item->course->course_name }}</strong>
                – ₹{{ $item->sell_price }}
            </li>
        @endforeach
    </ul>

</div>
@endsection
